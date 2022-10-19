<script lang="ts" context="module">
	import type { Load } from '@sveltejs/kit';

	export const load: Load = async ({ fetch, session }) => {
		const res = await fetch(`/api/about?locale=${session.locale}`);
		const data = await res.json();

		return { props: { data } };
	};
</script>

<script lang="ts">
	import dayjs from '$lib/dayjs';
	import type { About } from '$lib/types';
	import { goto } from '$app/navigation';
	import { session } from '$app/stores';
	import { _t } from '$lib/translations';

	export let data: About;

	export let t;

	session.subscribe(({ locale }) => {
		if (locale) {
			t = _t(locale);
		}
	});

	let availabilityString: string;
	let phoneHref: string;

	$: phoneHref = data.telephone.replace(/[.]/g, '');
</script>

<svelte:head>
	<title>
		{t('site.navigation.about')} ~ Échos virtuels
	</title>
</svelte:head>

<div class="tokyo_tm_about">
	<div class="about_image">
		<img src="/photo_wide.jpg" alt="about" />
	</div>

	<div class="description">
		<h3 class="name">Émile Plourde-Lavoie, <small>{data.job}</small></h3>
		<div class="description_inner">
			<div class="left typography">
				{@html data.bio}

				<div class="tokyo_tm_button">
					<button class="ib-button">Mes projets</button>
				</div>
			</div>

			<div class="right">
				<dl>
					<dt>{t('about.situation')}:</dt> <dd>{data.situation}</dd>
					<dt>{t('about.aka')}:</dt> <dd>{data.aka}</dd>
					<dt>{t('about.email')}:</dt> <dd><a href="mailto:{data.email}">{data.email}</a></dd>
					<dt>{t('about.phone')}:</dt> <dd><a href="tel:{phoneHref}">{data.telephone}</a></dd>
					<dt>{t('about.studies')}:</dt> <dd>{data.education}</dd>
					<dt>{t('about.availability')}:</dt> 
					<dd><a href="#">{t(`about.availabilities.${data.availability}`, t(`about.availabilities.undefined`))}</a></dd>
				</dl>
			</div>
		</div>
	</div>
</div>
