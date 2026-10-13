import { translate } from '../../resources/js/translation-api';
import { afterEach, beforeEach, describe, expect, it, jest } from '@jest/globals';
import { Client } from '@gradio/client';

jest.mock('@gradio/client', () => ({
	Client: {
		connect: jest.fn(),
	},
}));

jest.mock('../../resources/js/translation-config', () => ({
	nmtHost: 'test-user/test-space',
	nmtKey: 'test-token',
}));

describe('translate', () => {
	beforeEach(() => {
		jest.clearAllMocks();
	});

	afterEach(() => {
		jest.restoreAllMocks();
	});

	it('calls the Gradio translation endpoint and returns the translated text', async () => {
		const predict = jest.fn<(...args: unknown[]) => Promise<{ data: string }>>(
			() => Promise.resolve({ data: 'Xin chào' }),
		);
		jest.mocked(Client.connect).mockResolvedValue({ predict } as never);

		await expect(translate('Hello', 'en-GB', 'vi'))
			.resolves.toBe('Xin chào');

		expect(Client.connect).toHaveBeenCalledWith(
			'test-user/test-space',
			{ token: 'test-token' },
		);
		expect(predict).toHaveBeenCalledWith('/run_translation', {
			text: 'Hello',
			source_lang: 'en-gb',
			target_lang: 'vi',
		});
	});

	it('returns the service error if prediction fails', async () => {
		const predict = jest.fn<(...args: unknown[]) => Promise<{ data: string }>>(
			() => Promise.reject(new Error('Service unavailable')),
		);
		jest.mocked(Client.connect).mockResolvedValue({ predict } as never);
		jest.spyOn(console, 'error').mockImplementation(() => { });

		await expect(translate('Hello', 'en-GB', 'vi'))
			.resolves.toBe('Error connecting to translation service.');
	});
});
