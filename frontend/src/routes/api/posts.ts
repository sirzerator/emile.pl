import type { EndpointOutput } from '@sveltejs/kit';

export async function get(): Promise<EndpointOutput> {
	const res = await fetch(`${import.meta.env.VITE_BACKEND_URL}/posts`);
	const data = await res.json();

	return { body: data };
}
