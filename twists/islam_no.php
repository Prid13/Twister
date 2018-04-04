<?php

$url = "https://www.islam.no";

$twist = new Handler($url);

$twist->setHandler(function($html, &$items){
	$prayer_times = $html->find('.background_td_prayers_line', 0)->plaintext;
	echo $prayer_times;
		
		/*if(strpos(strtolower($tableData[0]), 'anime') !== false){
			for($i = 1; $i < count($tableData); $i++){
				$items[] = $tableData[$i]->first_child()->plaintext;
			}
		}*/
	
});

$twist->setTestFunction(function($items){
	var_dump($items);
});

$twist->test();

//var_dump($twist->diffTxt);

?>