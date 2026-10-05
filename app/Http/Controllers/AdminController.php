<?php

namespace App\Http\Controllers;

use App\Models\SavedSentence;
use Illuminate\Http\Request;
use Symfony\Component\Yaml\Yaml;

class AdminController extends Controller {
	public function export(Request $request) {
		if (!auth()->user()->is_admin) {
			abort(403, 'Unauthorized access.');
		}

		$popular = SavedSentence::query()
			->select('language_id', 'sentence')
			->selectRaw('COUNT(*) as count')
			->with('language')
			->groupBy('language_id', 'sentence')
			->orderByDesc('count')
			->get()
			->groupBy(fn($item) => $item->language->autonym)
			->map(function ($items) {
				$language = $items->first()->language;

				return [
					'bcp47' => $language->getTag(),
					'sentences' => $items->take(10)->map(function ($item) {
						return [
							'sentence' => $item->sentence,
							'count' => $item->count
						];
					})->values()->all()
				];
			})->sortKeys();

		// Export formats
		$format = $request->query('format', 'json');

		if ($format === 'yaml') {
			return response(Yaml::dump($popular->toArray(), 4, 2), 200, ['Content-Type' => 'text/yaml']);
		}

		if ($format === 'xml') {
			$xml = new \SimpleXMLElement('<Report/>');
			foreach ($popular as $autonym => $data) {
				$langNode = $xml->addChild('Language');
				$langNode->addAttribute('autonym', $autonym);
				$langNode->addAttribute('bcp47', $data['bcp47']); // Normalized tag next to autonym

				foreach ($data['sentences'] as $item) {
					$sentenceNode = $langNode->addChild('Item');
					$sentenceNode->addChild('Sentence', htmlspecialchars($item['sentence']));
					$sentenceNode->addChild('Count', $item['count']);
				}
			}
			return response($xml->asXML(), 200, ['Content-Type' => 'application/xml']);
		}

		return response()->json($popular);
	}
}
