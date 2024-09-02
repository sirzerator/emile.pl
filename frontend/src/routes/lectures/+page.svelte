<script lang="ts">
	import { page } from '$app/stores';

	import ReadingCard from '$lib/components/ReadingCard.svelte';

	import type { Reading } from '$lib/types';
	import { _t, _tl } from '$lib/translations';

	let locale;
	let readings: Reading[];
	let t;
	let tl;

	page.subscribe(({ data: { locale: l, data } }) => {
		readings = data;
		locale = l;
		if (locale) {
			t = _t(locale);
			tl = _tl(locale);
		}
	});
</script>

<svelte:head>
	<title>
		{t('site.navigation.readings')} ~ Échos virtuels
	</title>
</svelte:head>

<main>
	<div class="tokyo_tm_news emilepl__readings">
		<div class="tokyo_tm_title">
			<div>
				<div class="left">
					<h1>{t('site.navigation.readings')}</h1>
				</div>
			</div>
		</div>

		{#if readings.length > 0}
			<ul class="tokyo_tm_news_inner">
				{#each readings as reading}
					<ReadingCard reading={reading} {t} {tl} />
				{/each}
			</ul>
		{:else}
			<p class="tokyo_tm_news_nothing text-center"><em>{t('blog.nothing_to_display')}</em></p>
		{/if}
	</div>
</main>
