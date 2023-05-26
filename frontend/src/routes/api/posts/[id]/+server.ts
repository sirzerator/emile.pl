import qs from 'qs';
import { json } from '@sveltejs/kit';
import { defaultLocale } from '$lib/translations';
import type { RequestHandler } from './$types';

export const GET: RequestHandler = async ({ params, url: { searchParams } }) => {
	const locale: string = searchParams.get('locale') || defaultLocale;

	const query = qs.stringify({
		locale,
		fields: 'title,slug,content,intro,featured_image_url,published_at,category.title,tags.title,translations.slug',
	});

	const res = await fetch(`${import.meta.env.VITE_BACKEND_URL}/posts/${params.id}?${query}`);
	const post = await res.json();

	return json(post);
}
