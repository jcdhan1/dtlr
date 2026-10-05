<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>{{ __($pageTitle) . ' - ' . config('app.name', 'Digital Techniques for Language Revival') }}</title>

		<link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
		<link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
		
		<link rel="preconnect" href="https://fonts.bunny.net">
		<link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

		@vite(['resources/css/app.css', 'resources/js/app.js'])
	</head>
	<body class="font-sans antialiased text-slate-900">
		<div class="min-h-screen bg-slate-100 bg-[radial-gradient(circle_at_top,_rgba(59,130,246,0.10),_transparent_40%),linear-gradient(to_bottom,_#f8fafc,_#f1f5f9)]">
			@include('layouts.navigation')

			@if (isset($header))
				<header class="border-b border-slate-200 bg-white/80">
					<div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
						{{ $header }}
					</div>
				</header>
			@endif

			<main class="mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
				{{ $slot }}
			</main>
		</div>
		{{ $scripts ?? '' }}
	</body>
</html>
