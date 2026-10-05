<x-app-layout page-title="Home">
	<x-slot name="header">
		<div>
			<p class="text-xs font-semibold uppercase tracking-[0.24em] text-blue-600">Digital Techniques for Language Revival</p>
			<h1 class="mt-2 text-2xl font-black tracking-tight text-slate-900">Language, technology, and community</h1>
		</div>
	</x-slot>

	<div class="space-y-8 py-4">
		<section class="overflow-hidden rounded-3xl border border-slate-200 bg-white/80 shadow-[0_20px_45px_-20px_rgba(15,23,42,0.20)] backdrop-blur-sm">
			<div class="bg-gradient-to-br from-blue-50 via-white to-violet-50 px-6 py-12 sm:px-10 sm:py-16">
				<p class="text-sm font-bold uppercase tracking-[0.2em] text-blue-700">An interdisciplinary research project</p>
				<h2 class="mt-4 max-w-4xl text-4xl font-black leading-tight tracking-tight text-slate-900 sm:text-5xl">
					Digital Techniques for Language Revival
				</h2>
				<p class="mt-6 max-w-3xl text-lg leading-8 text-slate-600">
					We explore how technology can support comparative linguistics, language education, and the revitalisation and revival of languages.
				</p>
				<div class="mt-8 flex flex-wrap gap-3">
					<a href="{{ route('translate') }}" class="inline-flex items-center rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:from-blue-500 hover:to-indigo-500 focus:outline-none focus:ring-4 focus:ring-blue-100">
						Explore translation tools
					</a>
					<a href="#about" class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
						About the project
					</a>
				</div>
			</div>
		</section>

		<section id="about" class="grid gap-5 md:grid-cols-3">
			<article class="rounded-2xl border border-slate-200 bg-white/80 p-6 shadow-sm">
				<p class="text-xs font-bold uppercase tracking-[0.18em] text-blue-600">Compare</p>
				<h3 class="mt-3 text-lg font-bold text-slate-900">Comparative linguistics</h3>
				<p class="mt-3 text-sm leading-6 text-slate-600">
					Apply computational methods to explore language data, patterns, and relationships.
				</p>
			</article>

			<article class="rounded-2xl border border-slate-200 bg-white/80 p-6 shadow-sm">
				<p class="text-xs font-bold uppercase tracking-[0.18em] text-violet-600">Learn</p>
				<h3 class="mt-3 text-lg font-bold text-slate-900">Language education</h3>
				<p class="mt-3 text-sm leading-6 text-slate-600">
					Investigate how natural language processing can contribute to language learning and educational resources.
				</p>
			</article>

			<article class="rounded-2xl border border-slate-200 bg-white/80 p-6 shadow-sm">
				<p class="text-xs font-bold uppercase tracking-[0.18em] text-indigo-600">Revitalise</p>
				<h3 class="mt-3 text-lg font-bold text-slate-900">Language revitalisation</h3>
				<p class="mt-3 text-sm leading-6 text-slate-600">
					Explore digital techniques that can support efforts to revitalise and revive languages.
				</p>
			</article>
		</section>

		<section class="rounded-2xl border border-blue-100 bg-blue-50/70 p-6 sm:p-8">
			<h3 class="text-lg font-bold text-slate-900">Research through collaboration</h3>
			<p class="mt-3 max-w-4xl text-sm leading-6 text-slate-600">
				Digital Techniques for Language Revival brings together perspectives from language research and computational methods. Our aim is to explore practical ways technology can serve comparative linguistics, education, and language revitalisation.
			</p>
		</section>

		<section class="overflow-hidden rounded-3xl border border-slate-200 bg-white/80 shadow-sm">
			<div class="grid gap-8 p-6 sm:p-8 lg:grid-cols-[1fr_0.8fr] lg:p-10">
				<div>
					<p class="text-xs font-bold uppercase tracking-[0.2em] text-violet-600">Current study</p>
					<h3 class="mt-3 text-2xl font-black tracking-tight text-slate-900">Documenting Arem through sentences</h3>
					<p class="mt-4 text-sm leading-7 text-slate-600">
						Our current study focuses on documenting the critically endangered Arem language. We are developing a smartphone app to record sentences and support fieldwork to build a parallel corpus in English, Vietnamese, and Arem. By collecting language at the sentence level, the project aims to capture context and usage beyond word lists alone.
					</p>
					<p class="mt-4 text-sm leading-7 text-slate-600">
						The resulting corpus will support research into Arem grammar, the creation of a dictionary with example sentences showing how words are used, and the development of neural machine translation models.
					</p>
				</div>

				<aside class="rounded-2xl border border-violet-100 bg-gradient-to-br from-violet-50 via-white to-blue-50 p-6">
					<p class="text-xs font-bold uppercase tracking-[0.18em] text-violet-700">Call for collaborators</p>
					<h4 class="mt-3 text-lg font-bold text-slate-900">Are you a linguist or language researcher?</h4>
					<p class="mt-3 text-sm leading-6 text-slate-600">
						We welcome linguists and collaborators interested in revitalising Arem, fieldwork methods, corpus building, comparative linguistics, language education, or NLP. Your expertise can help shape useful tools and resources grounded in sentence-level language data.
					</p>
					<p class="mt-4 text-sm font-semibold leading-6 text-slate-700">
						If this work aligns with your interests, we would be glad to hear from you and explore ways to collaborate.
					</p>
				</aside>
			</div>
		</section>
	</div>
</x-app-layout>
