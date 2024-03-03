<script lang="ts">
	import type { PageData } from './$types';

	import { page } from '$app/stores';

	import { formatDate } from '$lib/dayjs';
	import { _t } from '$lib/translations';

	export let data: PageData;

	let t;

	page.subscribe(({ data: { locale } }) => {
		if (locale) {
			t = _t(locale);
		}
	});
</script>

<div class="tokyo_tm_news emilepl__blog__single">
	<div class="tokyo_tm_modalbox_news">
		{#if data.featured_image_url}
			<div class="image" style={`background-image: url('${data.featured_image_url}')`} />
		{/if}

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

			<h1 class="title">{data.title}</h1>
		</div>

		<div class="main_content typography">
			<p class="bigger">{data.intro}</p>

			{@html data.content}
		</div>
	</div>
</div>
