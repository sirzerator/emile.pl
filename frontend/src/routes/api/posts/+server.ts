import qs from 'qs';
import { json } from '@sveltejs/kit';
import { defaultLocale } from '$lib/translations';
import type { RequestHandler } from './$types';

export const GET: RequestHandler = async ({ url: { searchParams } }) => {
	const locale: string = searchParams.get('locale') || defaultLocale;

	const query = qs.stringify({
		locale,
		populate: 'author,image',
		sort: 'visibleAfter',
	});

	const res = await fetch(`${import.meta.env.VITE_BACKEND_URL}/posts?${query}`);
	const { data, meta: { pagination: { page, pageCount, pageSize, total } } } = await res.json();

	const posts = data.map(({
			id,
			attributes: {
				author: {
					data: author,
				},
				image: {
					data: image,
				},
				...post
			},
		}) => {
			return {
				id,
				author: author ? {
					id: author.id,
					...author.attributes,
				} : null,
				image: image ? {
					id: image.id,
					...image.attributes,
				} : null,
				...post
			};
	})
	return json({
		data: posts,
		total,
		page,
		pageCount,
		perPage: pageSize,
	});
}
