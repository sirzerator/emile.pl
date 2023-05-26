<script lang="ts">
	import type { PageData } from './$types';

	import { page } from '$app/stores';

	import dayjs from '$lib/dayjs';
	import type { Post } from '$lib/types';
	import { _t } from '$lib/translations';

	export let data: PageData;

	let t;

	page.subscribe(({ data: { locale } }) => {
		if (locale) {
			t = _t(locale);
		}
	});

	let socialList = [
		{
			name: 'Facebook',
			link: "https://www.facebook.com/",
			src: '/svg/social/facebook.svg',
		},
		{
			name: 'Twitter',
			link: "https://twitter.com/",
			src: '/svg/social/twitter.svg',
		},
	];

	const formatDate = (date) => dayjs(date).format('LL');
</script>

<div class="tokyo_tm_news">
	<div class="tokyo_tm_modalbox_news">
		<div class="image" style={`background-image: url('${data.featured_image_url}')`} />

		<div class="details">
			<div class="extra">
				<p class="date">
					<span>{formatDate(data.published_at)}</span>
				</p>

				{#if data.tags && data.tags.length > 0}
					<div class="tags">
						{#each data.tags as tag}
							<span class="tag">{tag.title}</span>
						{/each}
					</div>
				{/if}

				{#if data.category}
					<span class="category">{data.category.title}</span>
				{/if}
			</div>

			<h3 class="title">{data.title}</h3>
		</div>

		<div class="main_content ">
			<div class="descriptions">
				<p class="bigger">{data.intro}</p>

				<div class="typography">
					{@html data.content}
				</div>
			</div>
			<div class="news_share">
				<span>{t('interface.share')}:</span>
				<ul class="social">
					{#each socialList as social}
						<li>
							<a href={social.link} target="_blank" rel="noreferrer">
								<img class="svg" src={social.src} alt={social.name}>
							</a>
						</li>
					{/each}
				</ul>

			</div>
		</div>
	</div>
</div>
