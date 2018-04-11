<?php

$url = "https://fastpiratebay.co.uk/s/?q=1080p&page=0&orderby=99";

$twist = new Handler($url, "1080p BluRay Releases");

$twist->setHandler(function($html, &$items){
	foreach ($html->find('#searchResult > tr') as $tr) {
		$tableData = $tr->find("td", 1)->find(".detName", 0);
		
		$items[] = trim($tableData->plaintext);
	}
});

$twist->setTestFunction(function($items){
	var_dump($items);
});

$twist->start();

$twist->setPushMessage($token, $target, "New BluRay Rip");
$twist->setQPushMessage($pushName, $pushCode, "New BluRay Rip");
$twist->setGroupMeMessage($access_token, "7961fc01726f5de9c3fc55498b", "New BluRay Rip");

//var_dump($twist->diffTxt);

?>