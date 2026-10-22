<!DOCTYPE html>
<html lang="en-GB">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
	<style type="text/tailwindcss">
		@theme {
		--font-sans: "Figtree";
	  }
	</style>
	<title>Unzip Vite assets and composer dependencies</title>
</head>

<body>
	<main class="h-screen m-3">
		<?php
		$color = 'red';
		$status = 'Error';
		$response = null;
		$info = '';
		$secret = 'PLACEHOLDER_TOKEN';
		if (!isset($_GET['token']) || $_GET['token'] !== $secret) {
			$response = 'Token invalid.';
		} else {
			function removeDirectory(string $dir) {
				if (is_dir($dir)) {
					$files = new RecursiveIteratorIterator(
						new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
						RecursiveIteratorIterator::CHILD_FIRST
					);
					foreach ($files as $fileinfo) {
						$todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
						$todo($fileinfo->getRealPath());
					}
					rmdir($dir);
				}
			}

			$response = "";

			// 1. Process Frontend Build (Vite Assets)
			if (file_exists(__DIR__ . '/build.zip')) {
				removeDirectory(__DIR__ . '/public/build');
				$zip = new ZipArchive;
				if ($zip->open(__DIR__ . '/build.zip') === TRUE) {
					$zip->extractTo(__DIR__ . '/');
					$zip->close();
					unlink(__DIR__ . '/build.zip');
					$response .= "Frontend updated. ";
				}
			}

			// 2. Process Backend Vendor (Composer Dependencies)
			if (file_exists(__DIR__ . '/vendor.zip')) {
				removeDirectory(__DIR__ . '/vendor');
				$zip = new ZipArchive;
				if ($zip->open(__DIR__ . '/vendor.zip') === TRUE) {
					$zip->extractTo(__DIR__ . '/');
					$zip->close();
					unlink(__DIR__ . '/vendor.zip');
					$response .= "Vendor updated. ";

					// Clear the bootstrap cache to prevent Class Not Found / 500 errors
					$cacheFiles = ['packages.php', 'services.php'];
					foreach ($cacheFiles as $file) {
						$cachePath = __DIR__ . '/bootstrap/cache/' . $file;
						if (file_exists($cachePath)) {
							unlink($cachePath);
						}
					}
				}
			}

			// 3. Cleanup
			unlink(__FILE__); // Self-destruct

			$color = 'green';
			$status = 'Success';
			ob_start();
			phpinfo();
			$info = '<div class="px-3 mb-6 rounded-2xl border border-slate-200 bg-slate-100 h-3/4 overflow-y-auto">'
				.  ob_get_clean()
				. '</div>';
		}

		if (empty($response)) {
			$response = 'No zips found.';
		}
		echo <<<HTML
		<div class="p-3 my-3 text-sm rounded-lg text-{$color}-800 bg-{$color}-50" role="alert">
			<span class="font-bold">{$status}</span> {$response}
		</div>
		{$info}
		<a href="/" class="my-3 rounded-xl bg-linear-to-r from-blue-600 to-indigo-600 p-3 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:from-blue-500 hover:to-indigo-500 focus:outline-hidden focus:ring-4 focus:ring-blue-100">
			Return to home
		</a>
HTML;
		?>
	</main>
</body>

</html>
