<nav x-data="{ open: false }" class="border-b border-slate-200 bg-white/90 shadow-sm backdrop-blur-md">
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
		<div class="flex h-16 items-center justify-between">
			<div class="flex items-center">
				<div class="flex items-center">
					<a href="/" class="inline-flex items-center gap-2 rounded-full px-2 py-1 transition hover:bg-blue-50">
						<img src="{{ asset('favicon.svg') }}" class="h-8 w-8 rounded-full text-white shadow-sm" alt="Icon">
						<span class="text-xl font-black tracking-tight text-slate-900">DTLR</span>
					</a>
				</div>

				<div class="hidden items-center space-x-1 sm:ml-10 sm:flex">
					<x-nav-link :href="route('translate')" :active="request()->routeIs('translate')">
						{{ __('Translate') }}
					</x-nav-link>
					<x-nav-link :href="route('languages.index')" :active="request()->routeIs('languages.*')">
						{{ __('Languages') }}
					</x-nav-link>

					@auth
						@if(Auth::user()->is_admin)
							<div class="hidden sm:flex sm:items-center sm:ml-3">
								<x-dropdown align="right" width="48">
									<x-slot name="trigger">
										<button class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-medium text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 focus:outline-none">
											<span>Admin</span>
											<svg class="ml-2 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
												<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
											</svg>
										</button>
									</x-slot>

									<x-slot name="content">
										<x-dropdown-link :href="route('admin.export', ['format' => 'json'])">JSON Report</x-dropdown-link>
										<x-dropdown-link :href="route('admin.export', ['format' => 'xml'])">XML Report</x-dropdown-link>
										<x-dropdown-link :href="route('admin.export', ['format' => 'yaml'])">YAML Report</x-dropdown-link>
									</x-slot>
								</x-dropdown>
							</div>
						@endif
					@endauth
				</div>
			</div>

			<div class="hidden items-center sm:flex">
				@auth
					<x-dropdown align="right" width="48">
						<x-slot name="trigger">
							<button class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-medium text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 focus:outline-none">
								<span>{{ Auth::user()->name }}</span>
								<svg class="ml-2 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
								</svg>
							</button>
						</x-slot>

						<x-slot name="content">
							<x-dropdown-link :href="route('profile.edit')">
								{{ __('Profile') }}
							</x-dropdown-link>

							<form method="POST" action="{{ route('logout') }}">
								@csrf
								<x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
									{{ __('Log Out') }}
								</x-dropdown-link>
							</form>
						</x-slot>
					</x-dropdown>
				@else
					<div class="flex items-center gap-3">
						<a href="{{ route('login') }}" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:text-blue-600">
							Log in
						</a>
						<a href="{{ route('register') }}" class="rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
							Register
						</a>
					</div>
				@endauth
			</div>
		</div>
	</div>
</nav>
