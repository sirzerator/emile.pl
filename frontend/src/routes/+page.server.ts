import { defaultLocale } from '$lib/translations';
import type { About } from '$lib/types';
import type { PageLoad } from './$types';

export const load: PageLoad = async ({ fetch, parent }) => {
	const { locale } = await parent();
	const res = await fetch(`${import.meta.env.VITE_BACKEND_URL}/options/group/about?locale=${locale || defaultLocale}`);
	const data: About = await res.json();

	return data;
};
