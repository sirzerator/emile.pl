export const defaultLocale = 'en';
export const fallbackLocale = 'fr';

type SupportedLocales = 'fr' | 'en';
export const supportedLocales: SupportedLocales = ['fr', 'en'];

type MenuDefinition = Record<string, string>;
const menus: Record<SupportedLocales, Record<string, MenuDefinition>> = {
	fr: {
		sidebar: {
			about: '/a-propos',
			blog: '/blogue',
			contact: '/contact',
			home: '/',
			projects: '/projets',
		},
	},
	en: {
		sidebar: {
			about: '/about',
			blog: '/blog',
			contact: '/contact',
			home: '/',
			projects: '/projects',
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
			read_more: 'Lire plus',
		},
		contact: {
			fields: {
				name: 'Nom complet',
				email: 'Courriel',
				message: 'Message',
			},
			actions: {
				send_message: 'Envoyer',
			},
		},
		interface: {
			share: 'Partager',
		},
		site: {
			navigation: {
				about: 'À propos',
				blog: 'Blogue',
				contact: 'Contact',
				home: 'Accueil',
				projects: 'Projets',
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
			read_more: 'Read more',
		},
		contact: {
			fields: {
				name: 'Nom complet',
				email: 'Courriel',
				message: 'Message',
			},
			actions: {
				send_message: 'Envoyer',
			},
		},
		interface: {
			share: 'Share',
		},
		site: {
			navigation: {
				about: 'About',
				blog: 'Blog',
				contact: 'Contact',
				home: 'Home',
				projects: 'Projects',
			},
			slogan: "The web is a reflection of our society; of which it is, in sum, but a virtual echo.",
			title: 'Virtual Echoes',
		},
	},
};

type Dig = ((target: Record<string, any>, key: string) => string | null);
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
