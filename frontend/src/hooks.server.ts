import { parse } from 'cookie';
import { defaultLocale, supportedLocales } from '$lib/translations';

const getLocaleFromCookie = (header: string): string | null => {
	const cookie = parse(header)

	if (typeof cookie.lang === 'string') {
		if (supportedLocales.includes(cookie.lang)) {
			return cookie.lang;
		}
	}

	return null;
};

const getLocaleFromHeader = (header: string): string | null => {
	if (header === '') {
		return null;
	}

	const acceptLanguages =  header
		.split(',')
		.map((langDef) => langDef.split(';'))
		.sort((a, b) => (a[1] || 'q=1') < (b[1] || 'q=1') ? 1 : -1)
		.map((langDef) => {
			const [locale, variant] = langDef[0].split('-');
			return {
				locale: locale.toLowerCase(),
				variant: variant ? variant.toLowerCase() : null,
				fullLocale: langDef[0],
			};
		});

	for (let i = 0; i < 2; i++) {
		const { locale } = acceptLanguages[i];

		if (supportedLocales.includes(locale)) {
			return locale;
		}
	}

	return null;
};

export const handle = async ({ event, resolve }) => {
	const locale = getLocaleFromCookie(event.request.headers.get('cookie') || '')
		|| getLocaleFromHeader(event.request.headers.get('accept-language') || '')
		|| defaultLocale;

	event.locals.locale = locale;

	return resolve(event, {
		transformPageChunk: ({ html }) => html.replace(/<html.*>/, `<html lang="${locale}">`),
	});
};
