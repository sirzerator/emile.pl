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

	export let data: About;

	let availabilityString: string;
	let phoneHref: string;

	$: phoneHref = data.telephone.replace(/[.]/g, '');
	$: {
		availabilityString = 'Indéterminé';
		switch (data.availability) {
			case 'short_term':
				availabilityString = 'À court terme';
				break;
			case 'medium_term':
				availabilityString = 'À moyen terme';
				break;
			case 'long_term':
				availabilityString = 'À long terme';
				break;
			case 'available':
				availabilityString = 'Disponible';
				break;
		}
	}
</script>

<svelte:head>
	<title>
		À propos ~ Échos virtuels
	</title>
</svelte:head>

<div class="tokyo_tm_about">
	<div class="about_image">
		<img src="/photo_wide.jpg" alt="about" />
	</div>

	<div class="description">
		<h3 class="name">Émile Plourde-Lavoie, {data.job}</h3>
		<div class="description_inner">
			<div class="left typography">
				{@html data.bio}

				<div class="tokyo_tm_button">
					<button class="ib-button">Mes projets</button>
				</div>
			</div>

			<div class="right">
				<dl>
					<dt>Situation:</dt> <dd>{data.situation}</dd>
					<dt>AKA:</dt> <dd>{data.aka}</dd>
					<dt>Courriel:</dt> <dd><a href="mailto:{data.email}">{data.email}</a></dd>
					<dt>Téléphone:</dt> <dd><a href="tel:{phoneHref}">{data.telephone}</a></dd>
					<dt>Études:</dt> <dd>{data.education}</dd>
					<dt>Freelance:</dt> <dd><a href="#">{availabilityString}</a></dd>
				</dl>
			</div>
		</div>
	</div>
</div>
