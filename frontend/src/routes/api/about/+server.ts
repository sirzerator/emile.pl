import { json } from '@sveltejs/kit';
import timeout from '$lib/timeout';
import { defaultLocale } from '$lib/translations';
import type { RequestHandler } from './$types';

export const GET: RequestHandler = async ({ url: { searchParams } }) => {
	const locale: string = searchParams.get('locale') || defaultLocale;
	const res = await fetch(`${import.meta.env.VITE_BACKEND_URL}/options/group/about?locale=${locale}`);
	const data = await res.json();

	return json(data);
}
