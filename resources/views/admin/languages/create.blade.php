<x-app-layout :page-title="$isEditing ? 'Edit language' : ($clonedFrom ? 'Clone language' : 'Add language')">
	<x-slot name="header">
		<div>
			<p class="text-xs font-semibold uppercase tracking-[0.24em] text-blue-600">Administration</p>
			<h2 class="mt-2 text-2xl font-black tracking-tight text-slate-900">
				{{ $isEditing ? 'Edit language' : ($clonedFrom ? 'Clone language' : 'Add language') }}
			</h2>
		</div>
	</x-slot>

	<div class="mx-auto max-w-4xl">
		@if ($clonedFrom)
			<div class="mb-5 rounded-2xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800">
				Cloning {{ $clonedFrom->autonym }}. Edit any fields below, then save to create a separate language.
			</div>
		@endif

		@if ($errors->any())
			<div role="alert" class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
				<p class="font-semibold">Please correct the following fields:</p>
				<ul class="mt-2 list-inside list-disc">
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<form method="POST" action="{{ $isEditing ? route('languages.update', $language) : route('languages.store') }}" class="space-y-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
			@csrf
			@if ($isEditing)
				@method('PUT')
			@endif

			<div>
				<label for="autonym" class="mb-2 block text-sm font-semibold text-slate-700">Autonym <span class="text-rose-600">*</span></label>
				<input id="autonym" name="autonym" type="text" value="{{ old('autonym', $language->autonym) }}" required class="block w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 shadow-sm focus:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100">
				@error('autonym')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
			</div>

			<div>
				<label for="metadata" class="mb-2 block text-sm font-semibold text-slate-700">Metadata <span class="font-normal text-slate-500">(JSON)</span></label>
				<textarea id="metadata" name="metadata" rows="8" spellcheck="false" class="block w-full rounded-xl border border-slate-300 px-3.5 py-3 font-mono text-sm text-slate-800 shadow-sm focus:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100" placeholder='{"key": "value"}'>{{ old('metadata', $language->metadata) }}</textarea>
				<p class="mt-1 text-xs text-slate-500">Enter valid JSON, or leave blank for no metadata.</p>
				@error('metadata')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
			</div>

			<fieldset>
				<legend class="mb-2 block text-sm font-semibold text-slate-700">Enabled for</legend>
				<div class="flex flex-wrap gap-5">
					<label class="inline-flex items-center gap-2 text-sm text-slate-700">
						<input type="checkbox" name="site" value="1" @checked(old('site', $language->site)) class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
						Site
					</label>
					<label class="inline-flex items-center gap-2 text-sm text-slate-700">
						<input type="checkbox" name="nmt" value="1" @checked(old('nmt', $language->nmt)) class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
						NMT
					</label>
				</div>
			</fieldset>

			<div class="grid gap-5 sm:grid-cols-2">
				<div>
					<label for="iso_639_3" class="mb-2 block text-sm font-semibold text-slate-700">ISO 639-3 <span class="text-rose-600">*</span></label>
					<input id="iso_639_3" name="iso_639_3" type="text" size="3" maxlength="3" required value="{{ old('iso_639_3', $language->iso_639_3) }}" class="inline-block rounded-xl border border-slate-300 px-3.5 py-2.5 font-mono text-sm text-slate-800 shadow-sm focus:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100">
					@error('iso_639_3')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
				</div>
				<div>
					<label for="iso_15924" class="mb-2 block text-sm font-semibold text-slate-700">ISO 15924</label>
					<input id="iso_15924" name="iso_15924" type="text" size="4" maxlength="4" value="{{ old('iso_15924', $language->iso_15924) }}" class="inline-block rounded-xl border border-slate-300 px-3.5 py-2.5 font-mono text-sm text-slate-800 shadow-sm focus:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100">
					@error('iso_15924')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
				</div>
				<div>
					<label for="iso_3166_alpha_2" class="mb-2 block text-sm font-semibold text-slate-700">ISO 3166 alpha-2</label>
					<input id="iso_3166_alpha_2" name="iso_3166_alpha_2" type="text" size="2" maxlength="2" value="{{ old('iso_3166_alpha_2', $language->iso_3166_alpha_2) }}" class="inline-block rounded-xl border border-slate-300 px-3.5 py-2.5 font-mono text-sm text-slate-800 shadow-sm focus:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100">
					@error('iso_3166_alpha_2')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
				</div>
				<div>
					<label for="glottocode" class="mb-2 block text-sm font-semibold text-slate-700">Glottocode</label>
					<input id="glottocode" name="glottocode" type="text" size="8" maxlength="8" value="{{ old('glottocode', $language->glottocode) }}" class="inline-block rounded-xl border border-slate-300 px-3.5 py-2.5 font-mono text-sm text-slate-800 shadow-sm focus:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100">
					@error('glottocode')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
				</div>
				<div>
					<label for="wals" class="mb-2 block text-sm font-semibold text-slate-700">WALS</label>
					<input id="wals" name="wals" type="text" size="3" maxlength="3" value="{{ old('wals', $language->wals) }}" class="inline-block rounded-xl border border-slate-300 px-3.5 py-2.5 font-mono text-sm text-slate-800 shadow-sm focus:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100">
					@error('wals')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
				</div>
			</div>

			<div class="flex flex-wrap items-center gap-3 border-t border-slate-100 pt-5">
				<button type="submit" class="inline-flex items-center rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:from-blue-500 hover:to-indigo-500">
					{{ $isEditing ? 'Save changes' : 'Create language' }}
				</button>
				<a href="{{ route('languages.index') }}" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
					Cancel
				</a>
			</div>
		</form>
	</div>
</x-app-layout>
