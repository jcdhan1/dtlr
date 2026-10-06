<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

abstract class FeatureTestCase extends TestCase {
	use RefreshDatabase;

	protected function debugResponse(TestResponse $response): void {
		if ($response->status() >= 400) {
			echo "\n=== Response Debug ===\n";
			echo "Status: {$response->status()}\n";
			if ($response->exception) {
				echo "Exception: {$response->exception->getMessage()}\n";
				echo "File: {$response->exception->getFile()}:{$response->exception->getLine()}\n";
			}
			echo "Content:\n{$response->getContent()}\n";
			echo "=== End Debug ===\n";
		}
	}
}
