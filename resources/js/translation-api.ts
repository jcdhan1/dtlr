import { Client } from "@gradio/client";

const space = import.meta.env.VITE_NMT_HOST;
const token = import.meta.env.VITE_NMT_KEY;

export async function translate(
	text: string,
	sourceLangCode: string,
	targetLangCode: string
): Promise<string> {
	const client = await Client.connect(space, { token: token });

	try {
		const result = await client.predict<string>("/run_translation", {
			text: text,
			source_lang: sourceLangCode.toLowerCase(),
			target_lang: targetLangCode.toLocaleLowerCase(),
		});

		return result.data;
	} catch (error) {
		console.error("Translation API failed:", error);
		return "Error connecting to translation service.";
	}
}
