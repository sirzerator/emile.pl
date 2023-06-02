import { json } from '@sveltejs/kit';
import type { RequestHandler } from './$types';

export const GET: RequestHandler = async ({ url: { search, pathname } }) => {
	const res = await fetch(`${import.meta.env.VITE_BACKEND_URL}${pathname}${search}`);
	const data = await res.json();

	return json(data);
}
