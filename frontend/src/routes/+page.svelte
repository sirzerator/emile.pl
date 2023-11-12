<script lang="ts">
	import { page } from '$app/stores';

	import type { About } from '$lib/types';
	import { _t } from '$lib/translations';

	export let data: About;

	let t;

	page.subscribe(({ data: { locale } }) => {
		if (locale) {
			t = _t(locale);
		}
	});
</script>

<svelte:head>
	<title>
		Émile Plourde-Lavoie ~
		{t('site.title')}
	</title>
</svelte:head>

<div class="tokyo_tm_home">
	<div class="home_content">
		<div class="avatar">
			<div class="image avatar_img"><img alt="Avatar" src="/avatar.jpg"></div>
		</div>

		<div class="details">
			<h3 class="name">Émile<br>Plourde-Lavoie</h3>
			<p class="job">{data.job}</p>

			<div class="social">
				<a href="https://github.com/sirzerator" target="_blank">
					<img class="svg" src="/svg/github-mark.svg" alt="Github">
				</a>
			</div>
		</div>

	</div>
</div>
