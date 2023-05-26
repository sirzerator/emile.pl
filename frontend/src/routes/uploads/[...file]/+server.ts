import type { RequestHandler } from './$types';

export const GET: RequestHandler = async ({ params }) => {
	const res = await fetch(`${import.meta.env.VITE_ASSETS_URL}/${params.file}`);
	const data = await res.arrayBuffer();

	const headers = {};

	const extension = params.file.split('.').pop().toLowerCase();
	switch (extension) {
		case 'png':
			headers['Content-Type'] = 'image/png';
			break;
		case 'jpeg':
		case 'jpg':
			headers['Content-Type'] = 'image/jpg';
			break;
	}

	return new Response(new Uint8Array(data), {
		headers,
	});
}
