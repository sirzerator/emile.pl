import type { About } from '$lib/types';
import type { PageLoad } from './$types';

export const load: PageLoad = async ({ fetch, parent }) => {
	const { locale } = await parent();
	const res = await fetch(`/api/about?locale=${locale}`);
	const data = await res.json();

	return data;
};
