@php
	$languageOptions = [];
	forEach($languages as $language) {
		$languageOptions[] = [
			'value' => $language->getTag(),
			'label' => $language->autonym,
			'id' => $language->id
		];
	}
@endphp

<x-app-layout page-title="Translate">
	<x-slot name="header">
		<div class="flex items-center justify-between gap-4">
			<div>
				<p class="text-xs font-semibold uppercase tracking-[0.24em] text-blue-600">Language Tools</p>
			</div>
		</div>
	</x-slot>

	<iframe src="https://jcdhan-dtlr-nmt.hf.space" frameborder="0" width="850" height="450"></iframe>

	<x-slot name="scripts">
		@vite('resources/js/translate.ts')
	</x-slot>
</x-app-layout>
