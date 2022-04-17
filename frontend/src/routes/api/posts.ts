import qs from 'qs';
import type { EndpointOutput } from '@sveltejs/kit';

export async function get(): Promise<EndpointOutput> {
	const query = qs.stringify({
		populate: 'author,image',
	});

	const res = await fetch(`${import.meta.env.VITE_BACKEND_URL}/posts?${query}`);
	const data = await res.json();

	return { body: data };
}
