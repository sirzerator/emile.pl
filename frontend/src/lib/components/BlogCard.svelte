<script lang="ts">
	import dayjs from '$lib/dayjs';
	import type { Post } from '$lib/types';

	export let post: Post;
	export let t;

	let href: string;

	$: href = `/blogue/${post.id}/${post.slug}`

	const formatDate = (date) => dayjs(date).format('LL');
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
			</div>

			<h3 class="title">
				{post.title}
			</h3>

			<div class="intro">
				{post.intro}
			</div>

			<div class="tokyo_tm_read_more">
				<a><span>{t('blog.read_more')}</span></a>
			</div>
		</div>
	</a>
</li>
