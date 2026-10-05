<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TranslateController extends Controller {
	public function index() {
		/** @var User|null */
		$user = Auth::user();
		$savedSentences = Auth::check()
			? $user->savedSentences()->with('language')->latest()->get()
			: collect();

		$languages = Language::query()->where('nmt', '=', true)->orderBy('autonym')->get();

		return view('translate', compact('languages', 'savedSentences'));
	}

	public function save(Request $request) {
		/** @var User|null */
		$user = Auth::user();
		$request->validate([
			'language_id' => 'required|exists:languages,id',
			'sentence' => 'required|string',
		]);

		$user->savedSentences()->create([
			'language_id' => $request->language_id,
			'sentence' => $request->sentence,
		]);

		return back()->with('status', 'Sentence saved successfully!');
	}

	public function destroy(int $savedSentence) {
		/** @var User|null */
		$user = Auth::user();
		$user->savedSentences()->whereKey($savedSentence)->firstOrFail()->delete();

		return back()->with('status', 'Sentence deleted successfully!');
	}
}
