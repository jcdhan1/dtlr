<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;

class AdminLanguageController extends Controller {
	public function index() {
		$languages = Language::query()->orderBy('autonym')->paginate(25);

		return view('admin.languages.index', compact('languages'));
	}

	public function create() {
		$this->authorizeAdmin();

		return view('admin.languages.create', [
			'language' => new Language,
			'clonedFrom' => null,
			'isEditing' => false,
		]);
	}

	public function edit(Language $language) {
		$this->authorizeAdmin();

		return view('admin.languages.create', [
			'language' => $language,
			'clonedFrom' => null,
			'isEditing' => true,
		]);
	}

	public function clone(Language $language) {
		$this->authorizeAdmin();

		return view('admin.languages.create', [
			'language' => $language->replicate(),
			'clonedFrom' => $language,
			'isEditing' => false,
		]);
	}

	public function store(Request $request) {
		$this->authorizeAdmin();

		Language::create($this->validatedAttributes($request));

		return redirect()->route('languages.index')->with('status', 'Language created successfully.');
	}

	public function update(Request $request, Language $language) {
		$this->authorizeAdmin();

		$language->update($this->validatedAttributes($request));

		return redirect()->route('languages.index')->with('status', 'Language updated successfully.');
	}

	public function destroy(Language $language) {
		$this->authorizeAdmin();

		$language->delete();

		return redirect()->route('languages.index')->with('status', 'Language deleted successfully.');
	}

	private function validatedAttributes(Request $request): array {
		$validated = $request->validate([
			'autonym' => ['required', 'string'],
			'metadata' => ['nullable', 'json'],
			'site' => ['sometimes', 'boolean'],
			'nmt' => ['sometimes', 'boolean'],
			'iso_639_3' => ['required', 'string', 'size:3'],
			'iso_15924' => ['nullable', 'string', 'max:4'],
			'iso_3166_alpha_2' => ['nullable', 'string', 'max:2'],
			'glottocode' => ['nullable', 'string', 'max:8'],
			'wals' => ['nullable', 'string', 'max:3'],
		]);

		$validated['site'] = $request->boolean('site');
		$validated['nmt'] = $request->boolean('nmt');

		return $validated;
	}

	private function authorizeAdmin(): void {
		abort_unless(auth()->user()?->is_admin, 403, 'Unauthorized access.');
	}
}
