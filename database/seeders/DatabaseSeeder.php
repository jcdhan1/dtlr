<?php

namespace Database\Seeders;

use Illuminate\Database\MySqlConnection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Seed the application's database.
	 */
	public function run(): void {
		$connection = DB::table('languages')->connection;
		if ($connection instanceof MySqlConnection) {
			$connection->statement(<<<SQL
				SET SESSION sql_mode = CONCAT(@@SESSION.sql_mode, ',NO_AUTO_VALUE_ON_ZERO');
			SQL);
		}
		DB::table('languages')->upsert([
			[
				'id' => 0,
				'autonym' => 'Universal Symbol Language',
				'metadata' => null,
				'site' => false,
				'nmt' => false,
				'iso_639_3' => 'zxx',
				'iso_15924' => null,
				'iso_3166_alpha_2' => null,
				'variant' => null,
				'glottocode' => null,
				'wals' => null,
			],
			[
				'id' => 1,
				'autonym' => 'British English',
				'metadata' => null,
				'site' => true,
				'nmt' => true,
				'iso_639_3' => 'eng',
				'iso_15924' => 'Latn',
				'iso_3166_alpha_2' => 'GB',
				'variant' => null,
				'glottocode' => 'stan1293',
				'wals' => 'eng',
			],
			[
				'id' => 2,
				'autonym' => 'Tiếng Việt',
				'metadata' => null,
				'site' => false,
				'nmt' => true,
				'iso_639_3' => 'vie',
				'iso_15924' => 'Latn',
				'iso_3166_alpha_2' => null,
				'variant' => null,
				'glottocode' => 'viet1252',
				'wals' => 'vie',
			],
			[
				'id' => 3,
				'autonym' => 'cmrawˀ',
				'metadata' => null,
				'site' => false,
				'nmt' => false,
				'iso_639_3' => 'aem',
				'iso_15924' => null,
				'iso_3166_alpha_2' => null,
				'variant' => 'fonipa',
				'glottocode' => 'arem1240',
				'wals' => null,
			],
		], ['id']);
	}
}
