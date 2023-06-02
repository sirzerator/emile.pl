import qs from 'qs';
import { defaultLocale } from '$lib/translations';
import type { Post } from '$lib/types';
import type { PageLoad } from './$types';

export const load: PageLoad = async ({ fetch, parent }) => {
	const { locale } = await parent();

	const query = qs.stringify({
		locale: locale || defaultLocale,
		order: '-published_at',
		published: true,
		fields: 'title,slug,intro,featured_image_url,published_at,category.title',
	});

	const res = await fetch(`/api/posts?${query}`);
	const { data }: { data: Post[] } = await res.json();

	return { posts: data };
};
