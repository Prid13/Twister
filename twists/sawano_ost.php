<?php

$url = "https://en.wikipedia.org/wiki/Hiroyuki_Sawano";

$twist = new Handler($url);

$twist->setHandler(function($html, &$items){
	foreach ($html->find('.wikitable') as $tables) {
		$tableData = $tables->find("tbody tr");
		
		if(strpos(strtolower($tableData[0]), 'anime') !== false){
			for($i = 1; $i < count($tableData); $i++){
				$items[] = $tableData[$i]->first_child()->plaintext;
			}
		}
	}
});

$twist->start();

var_dump($twist->diffTxt);

?>