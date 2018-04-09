<?php

$url = "https://www.islam.no";

$twist = new Handler($url);

$twist->setHandler(function($html, &$items){
	$prayer_times = $html->find('.background_td_prayers_line', 0)->plaintext;
	
	$prayer_times = explode("Oslo:", $prayer_times)[1];
	$prayer_times = explode("-", $prayer_times);
	array_pop($prayer_times);
	
	foreach($prayer_times as $i => $time){
		$items[] = trim($time);
	}
	
});

$twist->setTestFunction(function($items){
	var_dump($items);
});

$twist->start();

$twist->setPushMessage($token, $target, "Bønnetider Oppdatert!");

//var_dump($twist->diffTxt);

?>