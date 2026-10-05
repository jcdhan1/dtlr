<?php

namespace Tests\Unit;

use App\Models\Language;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class LanguageTest extends TestCase {
	public static function getTagProvider(): array {
		return [
			'British English' => [
				['iso_639_3' => 'eng', 'iso_15924' => 'Latn', 'iso_3166_alpha_2' => 'GB'],
				'en-GB'
			],
			'Vietnamese' => [
				['iso_639_3' => 'vie', 'iso_15924' => 'Latn'],
				'vi'
			],
			'American English' => [
				['iso_639_3' => 'eng', 'iso_15924' => 'Latn', 'iso_3166_alpha_2' => 'US'],
				'en-US'
			],
			'Simplified Chinese' => [
				['iso_639_3' => 'zho', 'iso_15924' => 'Hans'],
				'zh-Hans'
			],
			'Traditional Chinese' => [
				['iso_639_3' => 'zho', 'iso_15924' => 'Hant'],
				'zh-Hant'
			],
			'Japanese' => [
				['iso_639_3' => 'jpn'],
				'ja'
			]
		];
	}

	#[DataProvider('getTagProvider')]
	public function test_get_tag(array $tagComponents, string $expectedTag): void {
		$language = new Language($tagComponents);

		$this->assertSame($expectedTag, $language->getTag());
	}
}
