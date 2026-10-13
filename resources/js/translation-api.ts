import { Client } from "@gradio/client";
import { nmtHost, nmtKey } from "./translation-config";

export async function translate(
	text: string,
	sourceLangCode: string,
	targetLangCode: string
): Promise<string> {
	const client = await Client.connect(nmtHost, { token: nmtKey });

	try {
		const result = await client.predict<string>("/run_translation", {
			text: text,
			source_lang: sourceLangCode.toLowerCase(),
			target_lang: targetLangCode.toLowerCase(),
		});

		return result.data;
	} catch (error) {
		console.error("Translation API failed:", error);
		return "Error connecting to translation service.";
	}
}
