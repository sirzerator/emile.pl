import type { EndpointOutput } from '@sveltejs/kit';

export async function get({ params }): Promise<EndpointOutput> {
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
			headers['Content-Type'] = 'image/png';
			break;
	}

	return {
		body: new Uint8Array(data),
		headers,
	};
}
