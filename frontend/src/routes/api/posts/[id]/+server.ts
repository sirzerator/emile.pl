import qs from 'qs';
import { json } from '@sveltejs/kit';
import { transformPost } from '$lib/transformers';
import { defaultLocale } from '$lib/translations';
import type { RequestHandler } from './$types';

export const GET: RequestHandler = async ({ params, url: { searchParams } }) => {
	const locale: string = searchParams.get('locale') || defaultLocale;

	const query = qs.stringify({
		locale,
		populate: 'author,image',
	});

	const res = await fetch(`${import.meta.env.VITE_BACKEND_URL}/posts/${params.id}?${query}`);
	const { data } = await res.json();

	return json(transformPost(data));
}
