<nav x-data="{ open: false }" class="border-b border-slate-200 bg-white/90 shadow-xs backdrop-blur-md">
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
		<div class="flex h-16 items-center justify-between">
			<div class="flex items-center">
				<div class="flex items-center">
					<a href="/" class="inline-flex items-center gap-2 rounded-full px-2 py-1 transition hover:bg-blue-50">
						<img src="{{ asset('favicon.svg') }}" class="h-8 w-8 rounded-full text-white shadow-xs" alt="Icon">
						<span class="text-xl font-black tracking-tight text-slate-900">DTLR</span>
					</a>
				</div>

				<!-- Desktop Navigation Links -->
				<div class="hidden items-center space-x-1 sm:ml-10 sm:flex">
					<x-nav-link :href="route('translate')" :active="request()->routeIs('translate')">
						{{ __('Translate') }}
					</x-nav-link>
					<x-nav-link :href="route('languages.index')" :active="request()->routeIs('languages.*')">
						{{ __('Languages') }}
					</x-nav-link>

					@auth
						@if(Auth::user()->is_admin)
							<div class="hidden sm:ml-3 sm:flex sm:items-center">
								<x-dropdown align="right" width="48">
									<x-slot name="trigger">
										<button class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-medium text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 focus:outline-hidden">
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

			<!-- Desktop Auth / User Dropdown -->
			<div class="hidden items-center sm:flex">
				@auth
					<x-dropdown align="right" width="48">
						<x-slot name="trigger">
							<button class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-medium text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 focus:outline-hidden">
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
						<a href="{{ route('register') }}" class="rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-xs transition hover:bg-slate-800">
							Register
						</a>
					</div>
				@endauth
			</div>

			<!-- Mobile Hamburger Button -->
			<div class="-mr-2 flex items-center sm:hidden">
				<button @click="open = ! open" class="inline-flex items-center justify-center rounded-md p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 focus:outline-hidden">
					<svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
						<path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
						<path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
					</svg>
				</button>
			</div>
		</div>
	</div>

	<!-- Mobile Responsive Navigation Menu -->
	<div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
		<div class="space-y-1 pb-3 pt-2">
			<x-responsive-nav-link :href="route('translate')" :active="request()->routeIs('translate')">
				{{ __('Translate') }}
			</x-responsive-nav-link>
			<x-responsive-nav-link :href="route('languages.index')" :active="request()->routeIs('languages.*')">
				{{ __('Languages') }}
			</x-responsive-nav-link>

			@auth
				@if(Auth::user()->is_admin)
					<div class="border-t border-slate-200 pb-1 pt-4">
						<div class="px-4 text-xs font-medium uppercase tracking-wider text-slate-500">Admin Tools</div>
						<div class="mt-2 space-y-1">
							<x-responsive-nav-link :href="route('admin.export', ['format' => 'json'])">JSON Report</x-responsive-nav-link>
							<x-responsive-nav-link :href="route('admin.export', ['format' => 'xml'])">XML Report</x-responsive-nav-link>
							<x-responsive-nav-link :href="route('admin.export', ['format' => 'yaml'])">YAML Report</x-responsive-nav-link>
						</div>
					</div>
				@endif
			@endauth
		</div>

		<!-- Mobile Responsive Auth/Profile Settings -->
		<div class="border-t border-slate-200 pb-3 pt-4">
			@auth
				<div class="px-4">
					<div class="text-base font-medium text-slate-800">{{ Auth::user()->name }}</div>
				</div>

				<div class="mt-3 space-y-1">
					<x-responsive-nav-link :href="route('profile.edit')">
						{{ __('Profile') }}
					</x-responsive-nav-link>

					<form method="POST" action="{{ route('logout') }}">
						@csrf
						<x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
							{{ __('Log Out') }}
						</x-responsive-nav-link>
					</form>
				</div>
			@else
				<div class="space-y-1">
					<x-responsive-nav-link :href="route('login')">
						{{ __('Log in') }}
					</x-responsive-nav-link>
					<x-responsive-nav-link :href="route('register')">
						{{ __('Register') }}
					</x-responsive-nav-link>
				</div>
			@endauth
		</div>
	</div>
</nav>
