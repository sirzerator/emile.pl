<script lang="ts">
	import dayjs from '$lib/dayjs';
	import type { Post } from '$lib/types';

	export let post: Post;
	export let t;

	let href: string;

	$: href = `/blogue/${post.id}/${post.attributes.slug}`

	const formatDate = (date) => dayjs(date).format('LL');
</script>

<li class="blog-card">
	<a class="list_inner" {href}>
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
				<a><span>{t('blog.read_more')}</span></a>
			</div>
		</div>
	</a>
</li>
