<script lang="ts" context="module">
	import Cookies from 'js-cookie';
	import { defaultLocale } from '$lib/translations';

	export const load = async ({ url, session, stuff }) => {
		const { pathname } = url;

		const cookieLocale = Cookies.get('lang');
		const sessionLocale = session.locale;
		const locale = cookieLocale || sessionLocale || defaultLocale;

		return {
			session: {
				locale,
			},
		};
	}
</script>

<script lang="ts">
	import "../style/main.scss";
	import { page, session } from '$app/stores';

	export let currentPath: string;
	page.subscribe(({ url: { pathname } }) => currentPath = pathname );

	session.subscribe(({ locale }) => {
		if (locale) {
			Cookies.set('lang', locale);
		}
	});
</script>

<div id="app" class="tokyo_tm_all_wrap emilepl">
	<div class="leftpart emilepl__sidebar">
		<div class="leftpart_inner">
			<div class="emilepl__sidebar__logo">
				<h1 class=""><a href="/">Échos virtuels</a></h1>
				<div class="emilepl__sidebar__logo__slogan">
					Le web est à l'image de notre société; il n'en est, en somme, qu'un écho virtuel.
				</div>
			</div>

			<div class="leftpart_languages typography">
				{#if $session.locale != 'en'}<a on:click="{() => $session.locale = 'en'}" href="#">English</a>{/if}
				{#if $session.locale != 'fr'}<a on:click="{() => $session.locale = 'fr'}" href="#">Français</a>{/if}
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

	<div class="rightpart emilepl__content">
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
