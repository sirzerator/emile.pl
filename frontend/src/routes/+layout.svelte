<script lang="ts">
	import Cookies from 'js-cookie';

	import "../style/main.scss";

	import { invalidateAll } from '$app/navigation';
	import { page } from '$app/stores';

	import dayjs from '$lib/dayjs';
	import { _t, _tl } from '$lib/translations';

	export let currentPath: string;

	export const setLocale = (locale) => {
		Cookies.set('lang', locale, { sameSite: 'strict' });
		invalidateAll();
	};

	let t;
	let tl;

	page.subscribe(({ url: { pathname } }) => currentPath = pathname );

	page.subscribe(({ data: { locale } }) => {
		if (locale) {
			t = _t(locale);
			tl = _tl(locale);
            dayjs.locale(locale);
		}
	});
</script>

<div id="app" class="tokyo_tm_all_wrap emilepl">
	<div class="leftpart emilepl__sidebar">
		<div class="leftpart_inner">
			<div class="emilepl__sidebar__logo">
				<h1 class=""><a href="/">{t('site.title')}</a></h1>
				<div class="emilepl__sidebar__logo__slogan">
					{t('site.slogan')}
				</div>
			</div>

			<div class="leftpart_languages typography">
				{#if $page.data.locale !== 'en'}<a on:click="{() => setLocale('en')}" href="#">English</a>{/if}
				{#if $page.data.locale !== 'fr'}<a on:click="{() => setLocale('fr')}" href="#">Français</a>{/if}
			</div>

			<div class="menu">
				<a class:active="{currentPath === tl('sidebar', 'home')}" href="{tl('sidebar', 'home')}">
					<img class="svg" src="/svg/home.svg" alt="" title="Accueil">
					<span class="menu_content">{t('site.navigation.home')}</span>
				</a>

				<a class:active="{currentPath === tl('sidebar', 'about')}" href="{tl('sidebar', 'about')}">
					<img class="svg" src="/svg/avatar.svg" alt="" title="À propos">
					<span class="menu_content">{t('site.navigation.about')}</span>
				</a>

				<a class:active="{currentPath === tl('sidebar', 'projects')}" href="{tl('sidebar', 'projects')}">
					<img class="svg" src="/svg/briefcase.svg" alt="" title="Projets">
					<span class="menu_content">{t('site.navigation.projects')}</span>
				</a>

				<a class:active="{currentPath === tl('sidebar', 'blog')}" href="{tl('sidebar', 'blog')}">
					<img class="svg" src="/svg/paper.svg" alt="" title="Blogue">
					<span class="menu_content">{t('site.navigation.blog')}</span>
				</a>

				<a class:active="{currentPath === tl('sidebar', 'contact')}" href="{tl('sidebar', 'contact')}">
					<img class="svg" src="/svg/mail.svg" alt="" title="Contact">
					<span class="menu_content">{t('site.navigation.contact')}</span>
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
