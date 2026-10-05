const initializeTranslation = () => {
	const tool = document.getElementById('translation-tool');

	if (!tool) {
		return;
	}

	const inputText = tool.querySelector('#input_text');
	const outputText = tool.querySelector('#output_text');
	const fromLang = tool.querySelector('#from_lang');
	const toLang = tool.querySelector('#to_lang');
	const saveForm = tool.querySelector('#save_sentence_form');
	const saveSentenceInput = tool.querySelector('#save_sentence');
	const saveLanguageInput = tool.querySelector('#save_language');
	let timeoutId;

	if (!inputText || !outputText || !fromLang || !toLang) {
		return;
	}

	const translate = async () => {
		const text = inputText.value.trim();
		const apiUrl = tool.dataset.apiUrl;

		if (!text) {
			outputText.value = '';
			return;
		}

		if (!apiUrl) {
			outputText.value = 'Translation service is not configured.';
			return;
		}

		outputText.value = 'Translating...';

		try {
			const response = await fetch(apiUrl, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
					'Accept': 'application/json',
				},
				body: JSON.stringify({
					text,
					from: fromLang.value,
					to: toLang.value,
				}),
			});
			const data = await response.json();

			if (!response.ok) {
				throw new Error(data.error || `Request failed (${response.status}).`);
			}

			if (data.translated_text) {
				outputText.value = data.translated_text;
			} else if (data.error) {
				outputText.value = `Error: ${data.error}`;
			} else {
				outputText.value = 'The translation service returned an unexpected response.';
			}
		} catch (error) {
			outputText.value = error instanceof Error
				? `Translation failed: ${error.message}`
				: 'Translation failed. Please try again.';
		}
	};

	if (saveForm && saveSentenceInput && saveLanguageInput) {
		saveForm.addEventListener('submit', () => {
			saveSentenceInput.value = inputText.value.trim();
			saveLanguageInput.value = fromLang.selectedOptions[0]?.dataset.languageId ?? '';
		});
	}

	inputText.addEventListener('input', () => {
		clearTimeout(timeoutId);
		timeoutId = setTimeout(translate, 500);
	});

	fromLang.addEventListener('change', translate);
	toLang.addEventListener('change', translate);

	tool.querySelectorAll('.insert-sentence').forEach((item) => {
		item.addEventListener('click', (event) => {
			const sentence = event.currentTarget.dataset.sentence;
			const language = event.currentTarget.dataset.lang;

			if (sentence === undefined || language === undefined) {
				return;
			}

			inputText.value = sentence;
			fromLang.value = language;
			translate();
		});
	});
};

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', initializeTranslation, { once: true });
} else {
	initializeTranslation();
}
