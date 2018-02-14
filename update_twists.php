<?php

header('Content-Type: text/html; charset=utf-8');

require("simple_html_dom.php");

$url = "https://en.wikipedia.org/wiki/Hiroyuki_Sawano";

$min_name = urlencode(basename($url));
$html = file_get_html($url);

$works_saved = [];

$fp = fopen('db/' . $min_name . '.txt', 'r');
$content = fread($fp, filesize('db/' . $min_name . '.txt'));
fclose($fp);

$works_saved = explode("\r\n", $content);

$works = [];

foreach ($html->find('.wikitable') as $tables) {
	$tableData = $tables->find("tbody tr");
	
	if(strpos(strtolower($tableData[0]), 'anime') !== false){
		for($i = 1; $i < count($tableData); $i++){
			$works[] = $tableData[$i]->first_child()->plaintext;
		}
	}
}

if(count(array_diff($works_saved, $works)) > 0){
	$text = "";
	
	for($i = 0; $i < count($works)-1; $i++)
		$text .= $works[$i] . "\r\n";
	
	$text .= $works[count($works)-1];
	
	$fp = fopen('db/' . $min_name . '.txt', 'w');
	fwrite($fp, $text);
	fclose($fp);
}

?>