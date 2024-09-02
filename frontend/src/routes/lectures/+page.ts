import qs from 'qs';
import { defaultLocale } from '$lib/translations';
import type { Reading } from '$lib/types';
import type { PageLoad } from './$types';

export const load: PageLoad = async ({ fetch, parent }) => {
	const { locale } = await parent();

	const query = qs.stringify({
		locale: locale || defaultLocale,
		order: '-finished_at',
		fields: 'title,slug,author,cover_image_url,finished_at,genre.title,post.title,post.slug',
	});

	const res = await fetch(`/api/readings?${query}`);
	const { data }: { data: Reading[] } = await res.json();

	return { data };
};
