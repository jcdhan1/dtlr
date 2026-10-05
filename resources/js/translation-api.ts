interface TranslationResponse {
	error?: unknown;
	translated_text?: unknown;
}

const isTranslationResponse = (value: unknown): value is TranslationResponse =>
	typeof value === 'object' && value !== null;

export const translate = async (
	text: string,
	fromLang: string,
	toLang: string,
	apiURL?: string,
): Promise<string> => {
	if (!apiURL) {
		throw new Error('Translation service is not configured.');
	}

	const response = await fetch(apiURL, {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
			'Accept': 'application/json',
		},
		body: JSON.stringify({ text, from: fromLang, to: toLang }),
	});
	const responseData: unknown = await response.json();

	if (!isTranslationResponse(responseData)) {
		throw new Error('The translation service returned an unexpected response.');
	}

	const data = responseData;

	if (!response.ok) {
		throw new Error(typeof data.error === 'string' ? data.error : `Request failed (${response.status}).`);
	}

	if (typeof data.error === 'string') {
		throw new Error(data.error);
	}

	if (typeof data.translated_text !== 'string') {
		throw new Error('The translation service returned an unexpected response.');
	}

	return data.translated_text;
};
