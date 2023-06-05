import { json } from '@sveltejs/kit';
import type { RequestHandler } from './$types';

export const POST: RequestHandler = async ({ request, url: { pathname, search } }) => {
	const payload = await request.json();
	const res = await fetch(`${import.meta.env.VITE_BACKEND_URL}${pathname}${search}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
		body: JSON.stringify(payload),
    })
    const data = await res.json();

    return json(data);
}
