import { sveltekit } from '@sveltejs/kit/vite';

/** @type {import('vite').UserConfig} */
const config = {
	plugins: [sveltekit()],
    resolve: {
        preserveSymlinks: true,
    },
};

export default config;
