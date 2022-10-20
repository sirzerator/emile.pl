<script lang="ts">
	import { page } from '$app/stores';
	import type { Post } from '$lib/types';

	export let data: About;
</script>

<svelte:head>
	<title>
		Émile Plourde-Lavoie ~
		{ data.siteName }
	</title>
</svelte:head>

<div class="tokyo_tm_home">
	<div class="home_content">
		<div class="avatar">
			<div class="image avatar_img"></div>
		</div>

		<div class="details">
			<h3 class="name">Émile<br>Plourde-Lavoie</h3>
			<p class="job">{data.job}</p>
		</div>
	</div>
</div>
