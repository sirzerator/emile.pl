export const defaultLocale = 'en';
export const fallbackLocale = 'fr';

export const supportedLocales = ['fr', 'en'] as const;
export type SupportedLocale = (typeof supportedLocales)[number];
export function isSupportedLocale(arg: string): arg is SupportedLocale {
	return supportedLocales.includes(arg as SupportedLocale);
}

type MenuDefinition = Record<string, string>;
const menus: Record<SupportedLocale, Record<string, MenuDefinition>> = {
	fr: {
		sidebar: {
			about: '/a-propos',
			blog: '/blogue',
			contact: '/contact',
			home: '/',
			projects: '/projets',
			readings: '/lectures',
		},
	},
	en: {
		sidebar: {
			about: '/about',
			blog: '/blog',
			contact: '/contact',
			home: '/',
			projects: '/projects',
			readings: '/readings',
		},
	},
}

const translations = {
	fr: {
		about: {
			aka: 'AKA',
			availabilities: {
				available: 'Disponible',
				long_term: 'Dans 6 mois',
				medium_term: 'Dans 3 mois',
				short_term: 'Le mois prochain',
				unavailable: 'Indisponible',
			},
			availability: 'Disponibilité',
			email: 'Courriel',
			my_projects: 'Mes projets',
			phone: 'Téléphone',
			situation: 'Situation',
			studies: 'Études',
		},
		blog: {
			nothing_to_display: 'Rien à afficher.',
			read_more: 'Lire plus',
		},
		contact: {
			fields: {
				name: 'Nom complet',
				email: 'Courriel',
				message: 'Message',
			},
			actions: {
				submit: 'Envoyer',
			},
			thanks: 'Merci pour votre message! Je vous reviens rapidement.',
		},
		interface: {
			share: 'Partager',
		},
		readings: {
			currently_reading: 'En cours de lecture',
			date_format: 'MMMM YYYY',
			finished_at: 'Terminé en',
			read_more: 'Lire ma critique',
		},
		site: {
			navigation: {
				about: 'À propos',
				blog: 'Blogue',
				contact: 'Contact',
				home: 'Accueil',
				projects: 'Projets',
				readings: 'Lectures',
			},
			slogan: "Le web est à l'image de notre société; il n'en est, en somme, qu'un écho virtuel.",
			title: 'Échos Virtuels',
		},
	},
	en: {
		about: {
			aka: 'AKA',
			availabilities: {
				available: 'Available',
				long_term: 'In 6 months',
				medium_term: 'In 3 months',
				short_term: 'Next month',
				unavailable: 'Unavailable',
			},
			availability: 'Availability',
			email: 'Email',
			my_projects: 'My projects',
			phone: 'Phone',
			situation: 'Location',
			studies: 'Studies',
		},
		blog: {
			nothing_to_display: 'Nothing to display.',
			read_more: 'Read more',
		},
		contact: {
			fields: {
				name: 'Full name',
				email: 'Email',
				message: 'Message',
			},
			actions: {
				submit: 'Send',
			},
			thanks: "Thank you for your message! I'll get back to you quickly.",
		},
		interface: {
			share: 'Share',
		},
		readings: {
			currently_reading: 'Currently reading',
			date_format: 'MMMM YYYY',
			finished_at: 'Finished in',
			read_more: 'Read my review',
		},
		site: {
			navigation: {
				about: 'About',
				blog: 'Blog',
				contact: 'Contact',
				home: 'Home',
				projects: 'Projects',
				readings: 'Readings',
			},
			slogan: "The web is a reflection of our society; of which it is, in sum, but a virtual echo.",
			title: 'Virtual Echoes',
		},
	},
};

type SimpleRecord<T> = { [key: string]: T };
interface RecursiveRecord extends SimpleRecord<RecursiveRecord> {}; //eslint-disable-line
type Dig = ((target: RecursiveRecord, key: string) => string | null);
const dig: Dig = (target, key) => {
	const parts = key.split('.');

	let current = target;
	for (let i = 0, len = parts.length; i < len; i++) {
		if (!current[parts[i]]) {
			return null;
		}

		current = current[parts[i]];
	}

	if (typeof current === 'string') {
		return current;
	}

	return JSON.stringify(current);
};

type _T = ((locale: string) => ((key: string, defaultTranslation?: string) => string));
export const _t: _T = (locale) => {
	return (key, defaultTranslation) => {
		const fullKey = `${locale}.${key}`;
		const fallbakKey = `${fallbackLocale}.${key}`;

		const translation = dig(translations, fullKey) || dig(translations, fallbakKey);

		return translation || defaultTranslation || fullKey;
	};
};

type _TL = ((locale: string) => ((menu: string, name: string) => string));
export const _tl: _TL = (locale) => {
	return (menu, name) => {
		const fullKey = `${locale}.${menu}.${name}`;
		const fallbakKey = `${fallbackLocale}.${menu}.${name}`;

		const translation = dig(menus, fullKey) || dig(menus, fallbakKey);

		return translation || fullKey;
	};
};
