<script lang="ts">
	import Cookies from 'js-cookie';

	import "../style/main.scss";

	import { goto, invalidateAll } from '$app/navigation';
	import { page } from '$app/stores';

	import dayjs from '$lib/dayjs';
	import { _t, _tl, supportedLocales } from '$lib/translations';

	export let currentPath: string;

	export const setLocale = (locale) => {
		Cookies.set('lang', locale, { sameSite: 'strict' });
		dayjs.locale(locale);
		if (translationPaths[locale]) {
			goto(translationPaths[locale], {
				replaceState: true,
				invalidateAll: true,
			});
		} else {
			goto('/', {
				replaceState: true,
				invalidateAll: true,
			});
			invalidateAll();
		}
	};

	let locale;
	let t;
	let tl;
	let translationPaths: Record<supportedLocales, string> = {
		en: '/',
		fr: '/',
	};

	page.subscribe(({ url: { pathname } }) => currentPath = pathname );

	page.subscribe(({ url: { pathname }, data: { translations, locale: l } }) => {
		if (l) {
			t = _t(l);
			tl = _tl(l);
            dayjs.locale(l);
		}

		translationPaths = {};
		locale = l;

		switch (pathname) {
			case '/blog':
			case '/blogue':
				translationPaths = {
					en: '/blog',
					fr: '/blogue',
				};
				break;
			case '/a-propos':
			case '/about':
				translationPaths = {
					en: '/about',
					fr: '/a-propos',
				};
				break;
			case '/lectures':
			case '/readings':
				translationPaths = {
					en: '/readings',
					fr: '/lectures',
				};
				break;
			case '/contact':
			case '/':
				translationPaths = {
					en: pathname,
					fr: pathname,
				};
				break;
			default:
				if (translations?.length > 0) {
					translationPaths = translations.reduce((acc, t) => {
						acc[t.locale] = t.path;
						return acc;
					}, {});
				}
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
				{#if $page.data.locale !== 'en' && translationPaths.en}
					<a on:click="{() => setLocale('en')}" href={translationPaths.en || $page.pathname}>English</a>
				{/if}
				{#if $page.data.locale !== 'fr' && translationPaths.fr}
					<a on:click="{() => setLocale('fr')}" href={translationPaths.fr || $page.pathname}>Français</a>
				{/if}
				{#if Object.keys(translationPaths).length === 0}
                    <span>&nbsp;</span>
                {/if}
			</div>

			<div class="menu">
				<a class:active="{currentPath === tl('sidebar', 'home')}" href="{tl('sidebar', 'home')}">
					<img class="svg" src="/svg/home.svg" alt="" title={t('site.navigation.home')}>
					<span class="menu_content">{t('site.navigation.home')}</span>
				</a>

				<a class:active="{currentPath === tl('sidebar', 'about')}" href="{tl('sidebar', 'about')}">
					<img class="svg" src="/svg/avatar.svg" alt="" title={t('site.navigation.about')}>
					<span class="menu_content">{t('site.navigation.about')}</span>
				</a>

				<a class:active="{currentPath === tl('sidebar', 'readings')}" href="{tl('sidebar', 'readings')}">
					<img class="svg" src="/svg/briefcase.svg" alt="" title="Projets">
					<span class="menu_content">{t('site.navigation.readings')}</span>
				</a>

				<a class:active="{currentPath === tl('sidebar', 'blog')}" href="{tl('sidebar', 'blog')}">
					<img class="svg" src="/svg/paper.svg" alt="" title={t('site.navigation.blog')}>
					<span class="menu_content">{t('site.navigation.blog')}</span>
				</a>

				<a class:active="{currentPath === tl('sidebar', 'contact')}" href="{tl('sidebar', 'contact')}">
					<img class="svg" src="/svg/mail.svg" alt="" title={t('site.navigation.contact')}>
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
