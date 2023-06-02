import qs from 'qs';
import { defaultLocale } from '$lib/translations';
import type { Post } from '$lib/types';
import type { PageLoad } from './$types';

export const load: PageLoad = async ({ fetch, params, parent }) => {
	const { locale } = await parent();

	const query = qs.stringify({
		locale: locale || defaultLocale,
		fields: 'title,slug,content,intro,featured_image_url,published_at,category.title,tags.title,translations.locale,translations.path',
	});

	const res = await fetch(`/api/posts/${params.id}?${query}`);
	const data: Post = await res.json();

	return data;
};
