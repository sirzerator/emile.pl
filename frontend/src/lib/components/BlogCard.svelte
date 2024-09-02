<script lang="ts">
	import { formatDate } from '$lib/dayjs';
	import type { Post } from '$lib/types';

	export let post: Post;
	export let t;
	export let tl;

	let href: string;

    $: href = `${tl('sidebar', 'blog')}/${post.id}/${post.slug}`
</script>

<li class="blog-card">
	<a class="list_inner" {href}>
		{#if post.featured_image_url}
			<div class="image">
				<img src={post.featured_image_url} alt="" />
				<div
					class="main"
					style={`background-image: url('${post.featured_image_url}')`}
				/>
			</div>
		{/if}

		<div class="details">
			<div class="extra">
                <p class="date">
                    <span>{formatDate(post.published_at)}</span>
                </p>
				{#if post.category}
					<span class="category">{post.category.title}</span>
				{/if}
			</div>

			<h3 class="title">
				{post.title}
			</h3>

			<div class="intro">
				{post.intro}
			</div>

			<div class="read-more">
				<span><span>{t('blog.read_more')}</span></span>
			</div>
		</div>
	</a>
</li>
