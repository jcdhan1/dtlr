<?php

namespace Tests\Feature;

use App\Models\Language;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLanguageTest extends FeatureTestCase {

	public function test_languages_page_is_public(): void {
		$response = $this->get(route('languages.index'));
		$this->debugResponse($response);
		$response->assertOk();
		$user = User::factory()->create(['is_admin' => false]);

		$this->actingAs($user)
			->get(route('languages.index'))
			->assertOk();
	}

	public function test_language_management_is_only_available_to_admins(): void {
		$this->get(route('languages.create'))->assertRedirect(route('login'));

		$user = User::factory()->create(['is_admin' => false]);

		$this->actingAs($user)
			->get(route('languages.create'))
			->assertForbidden();
	}

	public function test_admin_can_create_clone_edit_and_delete_a_language(): void {
		$admin = User::factory()->create(['is_admin' => true]);
		$this->actingAs($admin);

		$languageData = [
			'autonym' => 'Māori',
			'metadata' => '{"family":"Austronesian"}',
			'site' => '1',
			'iso_639_3' => 'mri',
			'iso_15924' => 'latn',
			'iso_3166_alpha_2' => 'nz',
			'glottocode' => 'maor1246',
			'wals' => 'mao',
		];

		$this->post(route('languages.store'), $languageData)
			->assertRedirect(route('languages.index'));

		$language = Language::query()->firstOrFail();
		$this->assertSame('Māori', $language->autonym);
		$this->assertTrue($language->site);
		$this->assertFalse($language->nmt);
		$this->assertSame('mri', $language->iso_639_3);
		$this->assertSame('latn', $language->iso_15924);
		$this->assertSame('nz', $language->iso_3166_alpha_2);

		$this->get(route('languages.clone', $language))
			->assertOk()
			->assertSee('value="Māori"', false)
			->assertSee('&quot;family&quot;:&quot;Austronesian&quot;', false);

		$cloneData = $languageData;
		$cloneData['autonym'] = 'Te Reo Māori';
		$cloneData['nmt'] = '1';

		$this->post(route('languages.store'), $cloneData)
			->assertRedirect(route('languages.index'));

		$this->assertDatabaseHas('languages', [
			'autonym' => 'Te Reo Māori',
			'iso_639_3' => 'mri',
			'site' => true,
			'nmt' => true,
		]);

		$updatedData = $languageData;
		$updatedData['autonym'] = 'Māori (updated)';
		$updatedData['site'] = '0';
		$updatedData['nmt'] = '1';

		$this->get(route('languages.edit', $language))
			->assertOk()
			->assertSee('value="Māori"', false);

		$this->put(route('languages.update', $language), $updatedData)
			->assertRedirect(route('languages.index'));

		$this->assertDatabaseHas('languages', [
			'id' => $language->id,
			'autonym' => 'Māori (updated)',
			'site' => false,
			'nmt' => true,
		]);

		$this->delete(route('languages.destroy', $language))
			->assertRedirect(route('languages.index'));

		$this->assertDatabaseMissing('languages', ['id' => $language->id]);
	}

	public function test_iso_639_3_and_autonym_are_required(): void {
		$admin = User::factory()->create(['is_admin' => true]);

		$this->actingAs($admin)
			->from(route('languages.create'))
			->post(route('languages.store'), ['autonym' => '', 'iso_639_3' => 'xx'])
			->assertSessionHasErrors(['autonym', 'iso_639_3']);

		$this->assertDatabaseCount('languages', 0);
	}
}
