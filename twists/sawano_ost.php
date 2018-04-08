<?php

$url = "https://en.wikipedia.org/wiki/Hiroyuki_Sawano";

$twist = new Handler($url);

$twist->setHandler(function($html, &$items){
	foreach ($html->find('.wikitable') as $tables) {
		$tableData = $tables->find("tr");
		
		if(strpos(strtolower($tableData[0]), 'anime') !== false){
			for($i = 1; $i < count($tableData); $i++){
				$items[] = $tableData[$i]->first_child()->plaintext;
			}
		}
	}
});

$twist->start();

//$pb = new Pushbullet($token);
//$pb->pushNote($target, "New Hiroyuki Sawano OST!", "Attack on Titan Season 4");

//var_dump($twist->diffTxt);

?>