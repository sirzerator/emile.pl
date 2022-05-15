import type { EndpointOutput } from '@sveltejs/kit';
import timeout from '$lib/timeout';

export async function get({ url: { searchParams } }): Promise<EndpointOutput> {
	const locale: string = searchParams.get('locale') || 'en';
	const res = await fetch(`${import.meta.env.VITE_BACKEND_URL}/about?locale=${locale}`);
	const { data } = await res.json();

	return { body: data.attributes };
}
