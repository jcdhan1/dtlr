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
				<h2 class="mt-2 text-2xl font-black tracking-tight text-slate-900">
					{{ __('Translate') }}
				</h2>
			</div>
			<div class="hidden rounded-full border border-blue-200 bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-700 sm:block">
				Instant translation
			</div>
		</div>
	</x-slot>

	<div id="translation-tool" class="py-8" data-api-url="{{ config('services.nmt.url') }}">
		<div class="mx-auto max-w-7xl">
			<div class="overflow-hidden rounded-3xl border border-slate-200 bg-white/80 shadow-[0_20px_45px_-20px_rgba(15,23,42,0.20)] backdrop-blur-sm">
				@if (session('status'))
					<div class="mx-6 mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
						{{ session('status') }}
					</div>
				@endif

				<div class="flex flex-col gap-6 p-6 md:flex-row">
					<section class="flex-1 rounded-2xl border border-slate-200 bg-gradient-to-br from-slate-50 via-white to-blue-50 p-5 shadow-sm">
						<div class="mb-5 flex items-center justify-between">
							<h3 class="text-lg font-bold text-slate-900">Input</h3>
							<span class="rounded-full bg-slate-200 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-slate-600">
								Source
							</span>
						</div>

						<div class="space-y-4">
							<x-language-select id="from_lang" label="Input Language" :options="$languageOptions" selected="{{ $languageOptions[0]['value'] }}" variant="blue" />

							<div>
								<label for="input_text" class="mb-2 block text-sm font-semibold text-slate-700">Text</label>
								<textarea id="input_text" rows="6" class="block w-full rounded-2xl border border-slate-200 bg-white px-3.5 py-3 text-sm text-slate-700 shadow-sm transition placeholder:text-slate-400 focus:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100" placeholder="Type text to translate..."></textarea>
							</div>
						</div>

						@auth
							<form id="save_sentence_form" action="{{ route('translate.save') }}" method="POST" class="mt-5">
								@csrf
								<input type="hidden" name="language_id" id="save_language">
								<input type="hidden" name="sentence" id="save_sentence">
								<button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:from-blue-500 hover:to-indigo-500 focus:outline-none focus:ring-4 focus:ring-blue-100 sm:w-auto">
									Save Sentence
								</button>
							</form>

							@if($savedSentences->isNotEmpty())
								<div class="mt-7 border-t border-slate-200 pt-5">
									<h3 class="mb-3 text-base font-bold text-slate-800">Your Saved Sentences</h3>
									<ul class="max-h-52 space-y-2 overflow-y-auto pr-1">
										@foreach($savedSentences as $saved)
											<li class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
												<div class="insert-sentence flex-1 cursor-pointer rounded-lg transition hover:bg-blue-50" data-sentence="{{ $saved->sentence }}" data-lang="{{ $saved->language->getTag() }}">
													<div class="flex items-start gap-2">
														<span class="inline-flex rounded-full bg-slate-100 px-2 py-1 text-[10px] font-bold uppercase tracking-[0.16em] text-slate-600">
															{{ $saved->language->getTag() }}
														</span>
														<span class="text-sm leading-6 text-slate-700">{{ $saved->sentence }}</span>
													</div>
												</div>
												<form action="{{ route('translate.saved.destroy', $saved) }}" method="POST" class="shrink-0">
													@csrf
													@method('DELETE')
													<button type="submit" class="rounded-lg px-2.5 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-200">
														Delete
													</button>
												</form>
											</li>
										@endforeach
									</ul>
								</div>
							@endif
						@endauth
					</section>

					<section class="flex-1 rounded-2xl border border-slate-200 bg-gradient-to-br from-slate-50 via-white to-violet-50 p-5 shadow-sm">
						<div class="mb-5 flex items-center justify-between">
							<h3 class="text-lg font-bold text-slate-900">Translation</h3>
							<span class="rounded-full bg-violet-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-violet-700">
								Output
							</span>
						</div>

						<div class="space-y-4">
							<x-language-select id="to_lang" label="Target Language" :options="$languageOptions" selected="{{ $languageOptions[1]['value'] }}" variant="violet" />

							<div>
								<label for="output_text" class="mb-2 block text-sm font-semibold text-slate-700">Result</label>
								<textarea id="output_text" rows="6" class="block w-full cursor-not-allowed rounded-2xl border border-slate-200 bg-slate-100 px-3.5 py-3 text-sm text-slate-700 shadow-inner placeholder:text-slate-400" readonly placeholder="Translation will appear here dynamically..."></textarea>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
	<x-slot name="scripts">
		@vite('resources/js/translate.js')
	</x-slot>
</x-app-layout>
