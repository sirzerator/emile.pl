<script lang="ts">
	import type { PageData } from './$types';

	import { page } from '$app/stores';

	import type { Contact } from '$lib/types';
	import { _t } from '$lib/translations';

	export let data: PageData;

	let loading = false;
	let sent = false;
	let currentLocale;
	let t;

	page.subscribe(({ data: { locale } }) => {
		if (locale) {
			t = _t(locale);
			currentLocale = locale;
		}
	});

	export const onSubmit = async function (e) {
		const formData = new FormData(e.target);

		const data = {
			locale: currentLocale,
		};
		for (let field of formData) {
			const [key, value] = field;
			data[key] = value;
		}

		loading = true;

		const res = await fetch(`/api/contacts`, {
			method: 'POST',
			headers: {
			'Content-Type': 'application/json',
			},
			body: JSON.stringify(data)
		});

		await res.json();

		e.target.reset();
		loading = false;
		sent = true;

	}
</script>

<svelte:head>
	<title>
		{t('site.navigation.contact')} ~ Échos virtuels
	</title>
</svelte:head>

<div class="tokyo_tm_contact emilepl__contact">
	<div class="tokyo_tm_title">
		<div class="title_flex">
			<div class="left">
				{#if data.slogan}
					<span>{t('site.navigation.contact')}</span>
					<h3>{data.slogan}</h3>
				{:else}
					<h1>{t('site.navigation.contact')}</h1>
				{/if}
			</div>
		</div>
	</div>

	<div class="emilepl__contact__content typography">
		{@html data.content}
	</div>

	{#if sent}
		<div class="emilepl__contact__thanks">
			<p>{t('contact.thanks')}</p>
		</div>
	{:else}
		<div class="fields">
			<form class="contact_form" on:submit|preventDefault={onSubmit}>
				<div class="first">
					<ul>
						<li>
							<input maxlength="255" name="name" type="text" placeholder={t('contact.fields.name')} autocomplete="off" required="required" />
						</li>

						<li>
							<input maxlength="255" name="email" type="email" placeholder={t('contact.fields.email')} required="required" />
						</li>

						<li>
							<textarea name="message" placeholder={t('contact.fields.message')} required="required"></textarea>
						</li>
					</ul>
				</div>
				<div class="tokyo_tm_button">
					<button type="submit" class="ib-button" disabled={loading}>{t('contact.actions.submit')}</button>
				</div>
			</form>
		</div>
	{/if}
</div>
