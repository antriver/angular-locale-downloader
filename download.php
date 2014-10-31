<?php

if (empty($argv[1])) {
    die("\nPlease specify an Angular version as the first parameter");
} else {
    $angularVersion = $argv[1];
}

$outputDir = __DIR__ . '/i18n/';
$baseUrl = "https://code.angularjs.org/{$angularVersion}/i18n/";

function emptyDir($dir) {
    $files = glob($dir . '/*');
    foreach ($files as $file) {
      if (is_file($file)) {
        unlink($file);
      }
    }
}

function downloadLocale($name) {
	global $baseUrl, $outputDir;
	$fileUrl = $baseUrl . $name;
	file_put_contents($outputDir . $name, file_get_contents($fileUrl));
}

// Clear output directory
emptyDir($outputDir);

// Fetch the index page
$doc = new DOMDocument();
$doc->loadHTMLFile($baseUrl);

// Download all angular_locale_* files listed
$nodes = $doc->getElementsByTagName('a');
foreach ($nodes as $node) {
	$thisUrl = $node->nodeValue;

	if (strpos($thisUrl, 'angular-locale_') === 0) {
		echo "\n" . $thisUrl;
		downloadLocale($thisUrl);
	}

}
