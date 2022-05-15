export function getSession({ request }) {
	return {
		acceptLanguage: (request.headers.get('accept-language') || '')
			.split(',')
			.map((langDef) => langDef.split(';'))
			.sort((a, b) => (a[1] || 'q=1') < (b[1] || 'q=1') ? 1 : -1)
			.map((langDef) => {
				const [locale, variant] = langDef[0].split('-');
				return {
					locale,
					variant,
					fullLocale: langDef[0],
				};
			}),
	};
};
