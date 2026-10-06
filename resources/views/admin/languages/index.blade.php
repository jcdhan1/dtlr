<x-app-layout page-title="Languages">
	<x-slot name="header">
		<div class="flex flex-wrap items-center justify-between gap-4">
			<div>
				<p class="text-xs font-semibold uppercase tracking-[0.24em] text-blue-600">Language catalogue</p>
				<h2 class="mt-2 text-2xl font-black tracking-tight text-slate-900">Languages</h2>
			</div>
			@auth
				@if (Auth::user()->is_admin)
					<a href="{{ route('languages.create') }}" class="inline-flex items-center rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:from-blue-500 hover:to-indigo-500">
						Add language
					</a>
				@endif
			@endauth
		</div>
	</x-slot>

	<div class="space-y-5">
		@if (session('status'))
			<div role="status" class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
				{{ session('status') }}
			</div>
		@endif

		<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
			<div class="overflow-x-auto">
				<table class="min-w-full divide-y divide-slate-200 text-left text-sm">
					<thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
						<tr>
							<th scope="col" class="px-5 py-3">Autonym</th>
							<th scope="col" class="px-5 py-3">ISO 639-3</th>
							<th scope="col" class="px-5 py-3">ISO 15924</th>
							<th scope="col" class="px-5 py-3">ISO 3166-2</th>
							<th scope="col" class="px-5 py-3">Variant</th>
							<th scope="col" class="px-5 py-3">Glottocode</th>
							<th scope="col" class="px-5 py-3">WALS</th>
							<th scope="col" class="px-5 py-3" title="Whether the site can be used in this language.">Site</th>
							<th scope="col" class="px-5 py-3" title="Whether the NMT can translate from or to this language.">NMT</th>
							@auth
								@if (Auth::user()->is_admin)
									<th scope="col" class="px-5 py-3 text-right">Actions</th>
								@endif
							@endauth
						</tr>
					</thead>
					<tbody class="divide-y divide-slate-100">
						@forelse ($languages as $language)
							<tr class="align-top">
								<td class="px-5 py-4 font-semibold text-slate-900" lang="{{ $language->getTag() }}">{{ $language->autonym }}</td>
								<td class="whitespace-nowrap px-5 py-4 font-mono text-slate-700">{{ $language->iso_639_3 }}</td>
								<td class="whitespace-nowrap px-5 py-4 font-mono text-slate-700">{{ $language->iso_15924 }}</td>
								<td class="whitespace-nowrap px-5 py-4 font-mono text-slate-700">{{ $language->iso_3166_alpha_2 }}</td>
								<td class="whitespace-nowrap px-5 py-4 font-mono text-slate-700">{{ $language->variant }}</td>
								<td class="whitespace-nowrap px-5 py-4 hover:underline">
									@if ($language->glottocode)
										<a href="https://glottolog.org/resource/languoid/id/{{ $language->glottocode }}" target="_blank">{{ $language->glottocode }}</a>
									@endif
								</td>
								<td class="whitespace-nowrap px-5 py-4 hover:underline">
									@if ($language->wals)
										<a href="https://wals.info/languoid/lect/wals_code_{{ $language->wals }}" target="_blank">{{ $language->wals }}</a>
									@endif
								</td>
								<td class="whitespace-nowrap px-5 py-4">{{ $language->site ? 'Yes' : ''}}</td>
								<td class="whitespace-nowrap px-5 py-4">{{ $language->nmt ? 'Yes' : ''}}</td>
								@auth
									@if (Auth::user()->is_admin)
										<td class="whitespace-nowrap px-5 py-4 text-right">
											<div class="flex justify-end gap-2">
												<a href="{{ route('languages.edit', $language) }}" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700">
													Edit
												</a>
												<a href="{{ route('languages.clone', $language) }}" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700">
													Clone
												</a>
												<form method="POST" action="{{ route('languages.destroy', $language) }}" onsubmit="return confirm('Delete this language? This cannot be undone.');">
													@csrf
													@method('DELETE')
													<button type="submit" class="rounded-lg border border-rose-200 px-3 py-1.5 text-xs font-semibold text-rose-700 transition hover:bg-rose-50">
														Delete
													</button>
												</form>
											</div>
										</td>
									@endif
								@endauth
							</tr>
						@empty
							<tr>
								<td colspan="{{ Auth::check() && Auth::user()->is_admin ? 10 : 9 }}" class="px-5 py-10 text-center text-slate-500">No languages have been added yet.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
			@if ($languages->hasPages())
				<div class="border-t border-slate-200 px-5 py-4">{{ $languages->links() }}</div>
			@endif
		</div>
	</div>
</x-app-layout>
