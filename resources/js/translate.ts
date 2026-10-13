import { translate } from './translation-api';
import { initTooltips } from 'flowbite';

const tool = document.getElementById('translation_tool');

const initialiseTranslation = (): void => {
	if (!tool) {
		return;
	}

	initTooltips();

	const inputText = tool.querySelector<HTMLTextAreaElement>('#input_text');
	const outputText = tool.querySelector<HTMLTextAreaElement>('#output_text');
	const fromLang = tool.querySelector<HTMLSelectElement>('#from_lang');
	const toLang = tool.querySelector<HTMLSelectElement>('#to_lang');
	const runTranslation = tool.querySelector<HTMLButtonElement>('#run_translation');
	const copyTranslation = tool.querySelector<HTMLButtonElement>('#copy_translation');
	const saveForm = tool.querySelector<HTMLFormElement>('#save_sentence_form');
	const saveSentenceInput = tool.querySelector<HTMLInputElement>('#save_sentence');
	const saveLanguageInput = tool.querySelector<HTMLInputElement>('#save_language');

	if (!inputText || !outputText || !fromLang || !toLang || !runTranslation || !copyTranslation) {
		return;
	}

	const updateTranslation = async (): Promise<void> => {
		const text = inputText.value.trim();

		if (!text) {
			outputText.value = '';
			return;
		}

		outputText.value = 'Translating...';

		try {
			outputText.value = await translate(text, fromLang.value, toLang.value);
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

	runTranslation.addEventListener('click', updateTranslation);
	fromLang.addEventListener('change', updateTranslation);
	toLang.addEventListener('change', updateTranslation);
	copyTranslation.addEventListener('click', () => navigator.clipboard.writeText(outputText.value));

	tool.querySelectorAll('.insert-sentence').forEach((item) => {
		item.addEventListener('click', (event: Event) => {
			const mouseEvent = event as MouseEvent;
			const target = mouseEvent.currentTarget;

			if (!(target instanceof HTMLElement)) {
				return;
			}

			const sentence = target.dataset.sentence;
			const language = target.dataset.lang;

			if (sentence === undefined || language === undefined) {
				return;
			}

			inputText.value = sentence;
			fromLang.value = language;
			updateTranslation();
		});
	});
};

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', initialiseTranslation, { once: true });
} else {
	initialiseTranslation();
}
