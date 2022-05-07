<script lang="ts">
	import "../style/main.scss";
	import { page } from '$app/stores';

	export let currentPath;
	page.subscribe(({ url: { pathname } }) => currentPath = pathname );
</script>

<div id="app" class="tokyo_tm_all_wrap">
	<div class="leftpart">
		<div class="leftpart_inner">
			<div class="logo">
				<h1>Échos virtuels</h1>
				<div class="slogan">
					Le web est à l'image de notre société; il n'en est, en somme, qu'un écho virtuel.
				</div>
			</div>

			<div class="leftpart_languages typography">
				<a on:click="{() => lang = 'en'}" href="/en">English</a>
				<a on:click="{() => lang = 'fr'}" href="/fr">Français</a>
			</div>

			<div class="menu">
				<a class:active="{currentPath === '/'}" href="/">
					<img class="svg" src="/svg/home.svg" alt="" title="Accueil">
					<span class="menu_content">Accueil</span>
				</a>

				<a class:active="{currentPath === '/a-propos'}" href="/a-propos">
					<img class="svg" src="/svg/avatar.svg" alt="" title="À propos">
					<span class="menu_content">À propos</span>
				</a>

				<a class:active="{currentPath === '/projets'}" href="/projets">
					<img class="svg" src="/svg/briefcase.svg" alt="" title="Projets">
					<span class="menu_content">Projets</span>
				</a>

				<a class:active="{currentPath === '/blogue'}" href="/blogue">
					<img class="svg" src="/svg/paper.svg" alt="" title="Blogue">
					<span class="menu_content">Blogue</span>
				</a>

				<a class:active="{currentPath === '/contact'}" href="/contact">
					<img class="svg" src="/svg/mail.svg" alt="" title="Contact">
					<span class="menu_content"> Contact</span>
				</a>
			</div>
		</div>
	</div>

	<div class="rightpart">
		<div class="rightpart_in">
			<div class="tokyo_tm_section">
				<div class="container">
					<slot />
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Original theme by Ib-Themes (https://themeforest.net/user/ib-themes) -->
