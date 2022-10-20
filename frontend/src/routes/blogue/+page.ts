import type { Post } from '$lib/types';
import type { PageLoad } from './$types';

export const load: PageLoad = async ({ fetch, parent }) => {
	const { locale } = await parent();
	const res = await fetch(`/api/posts?locale=${locale}`);
	const { data }: { data: Post[] } = await res.json();

	return { posts: data };
};
