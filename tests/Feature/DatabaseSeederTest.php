<?php

namespace Tests\Feature;

use App\Models\Language;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
	use RefreshDatabase;

	public function test_it_seeds_core_languages_with_their_fixed_ids(): void
	{
		$this->seed();
		$this->seed();

		$languages = Language::query()->orderBy('id')->get();

		$this->assertSame([0, 1, 2, 3], $languages->modelKeys());
		$this->assertSame([
			'Universal Symbol Language',
			'British English',
			'Tiếng Việt',
			'cmrawˀ',
		], $languages->pluck('autonym')->all());
		$this->assertSame(['zxx', 'eng', 'vie', 'aem'], $languages->pluck('iso_639_3')->all());
	}
}
