<script lang="ts">
	import dayjs from '$lib/dayjs';
	import type { Reading } from '$lib/types';

	export let locale;
	export let reading: Reading;
	export let t;
	export let tl;

	let href: string;

	$: href = reading[`comments_${locale}`] ? `${tl('sidebar', 'readings')}/${reading.id}/${reading.slug}` : '#';

	const formatMonth = (date) => dayjs(date).format(t('readings.date_format'));
</script>

<li class="reading-card">
	<a class="list_inner" {href} class:no-link={!reading[`comments_${locale}`]}>
		{#if reading.cover_image_url}
			<div class="reading-card__image image">
				<img src={reading.cover_image_url} alt="" />
				<div
					class="main"
					style={`background-image: url('${reading.cover_image_url}')`}
				/>
			</div>
		{/if}

		<div class="details reading-card__details">
			<div class="extra">
				<p class="date">
					{#if reading.finished_at}
						<span>{t('readings.finished_at')} {formatMonth(reading.finished_at)}</span>
					{:else if reading.abandoned_at}
						<span>{t('readings.abandoned')}</span>
					{:else}
						<span>{t('readings.currently_reading')}</span>
					{/if}
				</p>
				{#if reading.genre}
					<span class="category">{reading.genre.title}</span>
				{/if}
			</div>

			<h3 class="title">
				{reading.title}
			</h3>

			<div class="author">
				{reading.author}
			</div>

			{#if reading[`comments_${locale}`]}
			<div class="tokyo_tm_read_more">
				<a><span>{t('readings.read_more')}</span></a>
			</div>
			{/if}
		</div>
	</a>
</li>
