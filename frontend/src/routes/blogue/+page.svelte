<script lang="ts">
	import type { PageData } from './$types';

	import { page } from '$app/stores';

	import BlogCard from '$lib/components/BlogCard.svelte';

	import type { Post } from '$lib/types';
	import { _t } from '$lib/translations';

	export let data: PageData;

	let posts: Post[];
	let t;

	page.subscribe(({ data: { locale, posts: postsData } }) => {
		posts = postsData;
		if (locale) {
			t = _t(locale);
		}
	});
</script>

<svelte:head>
	<title>
		{t('site.navigation.blog')} ~ Échos virtuels
	</title>
</svelte:head>

<main>
	<div class="tokyo_tm_news">
		<div class="tokyo_tm_title">
			<div class="title_flex">
				<div class="left">
					<h3>{t('site.navigation.blog')}</h3>
				</div>
			</div>
		</div>

		<ul class="tokyo_tm_news_inner">
			{#each posts as post}
				<BlogCard post={post} {t} />
			{/each}
		</ul>
	</div>
</main>
