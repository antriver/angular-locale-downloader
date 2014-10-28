<?php

$angularVersion = '1.2.23';
$outputDir = __DIR__ . '/i18n/';
$baseUrl = "https://code.angularjs.org/{$angularVersion}/i18n/";

function downloadLocale($name) {
	global $baseUrl, $outputDir;

	$fileUrl = $baseUrl . $outputDir;
	 
	file_put_contents($outputDir . $name, file_get_contents($fileUrl));
}

$doc = new DOMDocument();
$doc->loadHTMLFile($baseUrl);

$nodes = $doc->getElementsByTagName('a');

foreach ($nodes as $node) {
	$thisUrl = $node->nodeValue;

	if (strpos($thisUrl, 'angular-locale_') === 0) {
		echo "\n" . $thisUrl;
		downloadLocale($thisUrl);
	}

}
