<script lang="ts">
	import { page } from '$app/stores';

	import BlogCard from '$lib/components/BlogCard.svelte';

	import type { Post } from '$lib/types';
	import { _t, _tl } from '$lib/translations';

	let posts: Post[];
	let t;
	let tl;

	page.subscribe(({ data: { locale, posts: postsData } }) => {
		posts = postsData;
		if (locale) {
			t = _t(locale);
			tl = _tl(locale);
		}
	});
</script>

<svelte:head>
	<title>
		{t('site.navigation.blog')} ~ Échos virtuels
	</title>
</svelte:head>

<main>
	<div class="tokyo_tm_news emilepl__blog">
		<div class="tokyo_tm_title">
			<div class="title_flex">
				<div class="left">
					<h1>{t('site.navigation.blog')}</h1>
				</div>
			</div>
		</div>

		{#if posts.length > 0}
			<ul class="tokyo_tm_news_inner">
				{#each posts as post}
                    <BlogCard post={post} {t} {tl} />
				{/each}
			</ul>
		{:else}
			<p class="tokyo_tm_news_nothing text-center"><em>{t('blog.nothing_to_display')}</em></p>
		{/if}
	</div>
</main>
