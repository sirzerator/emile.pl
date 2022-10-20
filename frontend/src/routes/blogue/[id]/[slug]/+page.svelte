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
			link: "https://www.facebook.com/",
			src: 'require("../assets/img/svg/social/facebook.svg")',
		},
		{
			link: "https://twitter.com/",
			src: 'require("../assets/img/svg/social/twitter.svg")',
		},
	];

	const formatDate = (date) => dayjs(date).format('LL');
</script>

<div class="tokyo_tm_news">
	<div class="tokyo_tm_modalbox_news">
		<div class="image" style={`background-image: url('${data.image.formats.large.url}')`} />

		<div class="details">
			<div class="extra">
				{#if data.author}
					<p class="date">
						<a href="#">{data.author.fullname}</a>
						<span>{formatDate(data.publishedAt)}</span>
					</p>
				{:else}
					<p class="date">
						<span>{formatDate(data.publishedAt)}</span>
					</p>
				{/if}
			</div>

			<h3 class="title">
				{data.title}
			</h3>
		</div>

		<div class="main_content ">
			<div class="descriptions">
				<p class="bigger">
				{data.introduction}
				</p>

				<div class="typography">
					{@html data.content}
				</div>
			</div>

			<div class="news_share">
				<span>Share:</span>
				<ul class="social">
					<li v-for="(social, i) in socialList" :key="i">
						<a :href="social.link" target="_blank" rel="noreferrer">
							<img class="svg" :src="social.src" alt="social" />
						</a>
					</li>
				</ul>

			</div>
		</div>
	</div>
</div>
