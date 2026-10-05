<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Toobo\Bcp47;

class Language extends Model {
	use HasFactory;

	const BCP47_COMPONENTS = ['iso_639_3', 'iso_15924', 'iso_3166_alpha_2'];

	protected $fillable = ['autonym', 'metadata', 'site', 'nmt', 'iso_639_3', 'iso_15924', 'iso_3166_alpha_2', 'glottocode', 'wals'];

	protected $casts = [
		'site' => 'boolean',
		'nmt' => 'boolean',
	];

	/**
	 * Get the language's normalised IETF BCP 47 language tag.
	 *
	 * Normalisation includes:
	 * - Preferred values replacement when available
	 * - Case normalisation (all lowercase, but uppercase region and title-case script)
	 * - Script suppression when redundant
	 * - Replacement of numeric region codes with 2-chars alpha code when available
	 * - Replacement of 3-chars language code (ISO 639-3) with 2-chars code (ISO 636-1) when
	 *   available
	 *
	 * @return string
	 */
	public function getTag(): string {
		// Build the language's raw tag
		$tag = [];
		foreach (static::BCP47_COMPONENTS as $component) {
			$value = $this->$component;
			if (!empty($value)) {
				$tag[] = $value;
			}
		}

		$tag = join('-', $tag);

		// This package is stricter than the actual BCP 47 standard so fallback to the unnormalised tag when filterTag returns null.
		return Bcp47::filterTag($tag) ?? $tag;
	}
}
