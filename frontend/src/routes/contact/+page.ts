import { defaultLocale } from '$lib/translations';
import type { Contact } from '$lib/types';
import type { PageLoad } from './$types';

export const load: PageLoad = async ({ fetch, parent }) => {
	const { locale } = await parent();
	const res = await fetch(`${import.meta.env.VITE_BACKEND_URL}/options/group/contact?locale=${locale || defaultLocale}`);
	const data: Contact = await res.json();

	return data;
};
