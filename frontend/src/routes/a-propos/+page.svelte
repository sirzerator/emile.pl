<script lang="ts">
	import type { PageData } from './$types';

	import { page } from '$app/stores';

	import dayjs from '$lib/dayjs';
	import type { About } from '$lib/types';
	import { _t } from '$lib/translations';

	export let data: PageData;

	let phoneHref: string;
	let t;

	page.subscribe(({ data: { locale } }) => {
		if (locale) {
			t = _t(locale);
		}
	});

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

				<!--<div class="tokyo_tm_button">
					<a class="button" href="/projects">{t('about.my_projects')}</a>
				</div>-->
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
