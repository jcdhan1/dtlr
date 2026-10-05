<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale {
	public function handle($request, Closure $next) {
		if (! $request->user()) {
			return $next($request);
		}

		app()->setLocale('en-GB');

		return $next($request);
	}
}
