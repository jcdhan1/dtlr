<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Register any application services.
	 */
	public function register(): void {
		//
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void {
		// Usage: <tag @data('attrib', 'value')> => <tag data-attrib="value">
		Blade::directive('data', function (string $expression) {
			return "<?php 
			list(\$attr, \$value) = [{$expression}]; 
			if (!empty(\$value)) {
				echo 'data-' . \$attr . '=\"' . e(\$value) . '\"';
			}
		?>";
		});
	}
}
