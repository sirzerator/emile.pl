<script lang="ts">
	import type { PageData } from './$types';

	import { page } from '$app/stores';

	import dayjs from '$lib/dayjs';
	import type { Post } from '$lib/types';
	import { _t } from '$lib/translations';

	export let data: PageData;

	let posts: Post[];

	page.subscribe(({ data: { posts: postsData } }) => {
		posts = postsData;
	});

	function formatDate(date) { return dayjs(date).format('LL'); }
</script>

<svelte:head>
	<title>
		Blogue ~ Échos virtuels
	</title>
</svelte:head>

<main>
	<div class="tokyo_tm_news">
		<div class="tokyo_tm_title">
			<div class="title_flex">
				<div class="left">
					<span>Catégorie</span>
					<h3>Blogue</h3>
				</div>
			</div>
		</div>

		<ul class="tokyo_tm_news_inner">
			{#each posts as post}
			<li>
				<div class="list_inner">
					{#if post.attributes.image.data}
					<div class="image">
						<img src={post.attributes.image.data.attributes.formats.medium.url} alt="thumb" />
						<div
							class="main"
							style={`background-image: url('${post.attributes.image.data.attributes.formats.medium.url}')`}
						/>
					</div>
					{/if}

					<div class="details">
						<div class="extra">
							{#if false && post.attributes.author}
							<p class="date">
								By <a href="#">{post.attributes.author.data.attributes.fullname}</a>
								<span>{post.attributes.publishedAt}</span>
							</p>
							{:else}
							<p class="date">
								<span>{formatDate(post.attributes.publishedAt)}</span>
							</p>
							{/if}
						</div>

						<h3 class="title">
							{post.attributes.title}
						</h3>

						<div class="intro">
							{post.attributes.introduction}
						</div>

						<div class="tokyo_tm_read_more">
							<a href={`/blogue/${post.id}/${post.attributes.slug}`}><span>Read More</span></a>
						</div>
					</div>
				</div>
			</li>
			{/each}
		</ul>
	</div>
</main>
