import type { Post } from '$lib/types';
import type { PageLoad } from './$types';

export const load: PageLoad = async ({ fetch, params, parent }) => {
	const { locale } = await parent();
	const res = await fetch(`/api/posts/${params.id}?locale=${locale}`);
	const data: Post = await res.json();

	return data;
};
