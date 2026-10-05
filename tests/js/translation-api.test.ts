import { translate } from '../../resources/js/translation-api';
import { afterEach, beforeEach, describe, expect, it, jest } from '@jest/globals';

describe('translate', () => {
	beforeEach(() => {
		jest.spyOn(global, 'fetch');
	});

	afterEach(() => {
		jest.restoreAllMocks();
	});

	it('posts the translation request and returns the translated text', async () => {
		jest.mocked(fetch).mockResolvedValue({
			ok: true,
			json: async () => ({ translated_text: 'Xin chào' }),
		} as Response);

		await expect(translate('Hello', 'en-GB', 'vi', 'https://nmt.example/translate'))
			.resolves.toBe('Xin chào');

		expect(fetch).toHaveBeenCalledWith('https://nmt.example/translate', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'Accept': 'application/json',
			},
			body: JSON.stringify({ text: 'Hello', from: 'en-GB', to: 'vi' }),
		});
	});

	it('throws if no API URL is configured', async () => {
		await expect(translate('Hello', 'en-GB', 'vi'))
			.rejects.toThrow('Translation service is not configured.');

		expect(fetch).not.toHaveBeenCalled();
	});

	it('throws the API error for an unsuccessful response', async () => {
		jest.mocked(fetch).mockResolvedValue({
			ok: false,
			status: 503,
			json: async () => ({ error: 'Service unavailable' }),
		} as Response);

		await expect(translate('Hello', 'en-GB', 'vi', 'https://nmt.example/translate'))
			.rejects.toThrow('Service unavailable');
	});

	it('throws if the API response has no translated text', async () => {
		jest.mocked(fetch).mockResolvedValue({
			ok: true,
			json: async () => ({ result: 'Bonjour' }),
		} as Response);

		await expect(translate('Hello', 'en-GB', 'vi', 'https://nmt.example/translate'))
			.rejects.toThrow('The translation service returned an unexpected response.');
	});
});
