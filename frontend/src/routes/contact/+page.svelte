<script lang="ts">
	import type { PageData } from './$types';

	import { page } from '$app/stores';

	import type { Contact } from '$lib/types';
	import { _t } from '$lib/translations';

	export let data: PageData;

	let t;

	page.subscribe(({ data: { locale } }) => {
		if (locale) {
			t = _t(locale);
		}
	});

	export let onSubmit = function (e) {
		const formData = new FormData(e.target);

		const data = {};
		for (let field of formData) {
		  const [key, value] = field;
		  data[key] = value;
		}
        console.log(data);
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
					<h3>{t('site.navigation.contact')}</h3>
				{/if}
			</div>
		</div>
	</div>

	<div class="emilepl__contact__content typography">
		{@html data.content}
	</div>

	<div class="fields">
		<form class="contact_form" on:submit|preventDefault={onSubmit}>
			<div class="first">
				<ul>
					<li>
						<input type="text" placeholder={t('contact.fields.name')} autocomplete="off" required="required" />
					</li>

					<li>
						<input type="email" placeholder={t('contact.fields.email')} required="required" />
					</li>

					<li>
						<textarea placeholder={t('contact.fields.message')} required="required"></textarea>
					</li>
				</ul>
			</div>
			<div class="tokyo_tm_button">
				<button type="submit" class="ib-button">Send Message</button>
			</div>
		</form>
	</div>
</div>
