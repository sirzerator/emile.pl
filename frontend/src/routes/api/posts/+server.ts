import qs from 'qs';
import { json } from '@sveltejs/kit';
import { defaultLocale } from '$lib/translations';
import type { RequestHandler } from './$types';

export const GET: RequestHandler = async ({ url: { searchParams } }) => {
	const locale: string = searchParams.get('locale') || defaultLocale;

	const query = qs.stringify({
		locale,
		order: '-published_at',
        published: true,
		fields: 'title,slug,intro,featured_image_url,published_at,category.title,tags.title,translations.slug',
	});

	const res = await fetch(`${import.meta.env.VITE_BACKEND_URL}/posts?${query}`);
	const { data, current_page: page, last_page: pageCount, per_page: perPage, total } = await res.json();

	return json({
		data,
		total,
		page,
		pageCount,
		perPage,
	});
}
