<script lang="ts" context="module">
	import type { Load } from '@sveltejs/kit';

	export const load: Load = async ({ fetch }) => {
		const res = await fetch('/api/posts');
		const { data } = await res.json();

		return { props: { posts: data } };
	};
</script>

<script lang="ts">
	import type { Post } from '$lib/types';
	import { goto } from '$app/navigation';

	export let posts: Array<Post>;
</script>

<div class="my-4">
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
					<div class="image">
						<img src="/img/thumbs/4-3.jpg" alt="thumb" />
						<div
							class="main"
							style="background-image: /img/thumbs/4-3.jpg"
							></div>
					</div>
					<div class="details">
						<div class="extra">
							<p class="date">
							By <a href="#">{post.author.fullname}</a><span>{post.publishedAt}</span>
							</p>
						</div>
						<h3 class="title">
							{post.title}
						</h3>
						<div class="intro">
							{post.introduction}
						</div>
						<div class="tokyo_tm_read_more">
							<a><span>Read More</span></a>
						</div>
					</div>
				</div>
			</li>
			{/each}
		</ul>
	</div>
</div>
