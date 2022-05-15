<script lang="ts" context="module">
	import type { Load } from '@sveltejs/kit';

	export const load: Load = async ({ session }) => {
		for (let i = 0, len = session.acceptLanguage.length; i < len; i++) {
			const { locale } = session.acceptLanguage[i];
			switch (locale) {
				case 'fr':
				case 'en':
					return {
							status: 302,
							redirect: `/${locale}`,
					};
			}
		}
	};
</script>
