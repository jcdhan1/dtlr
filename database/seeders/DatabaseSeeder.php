<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
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
                'glottocode' => 'arem1240',
                'wals' => null,
            ],
        ], ['id'], [
            'autonym',
            'metadata',
            'site',
            'nmt',
            'iso_639_3',
            'iso_15924',
            'iso_3166_alpha_2',
            'glottocode',
            'wals',
        ]);
    }
}
