<?php

$url = "http://listmoz.com/view/5QFgr7wKv4RkVcBpJY8";
// edit url: http://listmoz.com/#hYxc0jhh38VFycdJY

$twist = new Handler($url);

$twist->setHandler(function($html, &$items){
	foreach ($html->find('#view tr') as $tr) {
		$tableData = $tr->find("td", 1)->find("p", 0);
		
		$items[] = $tableData->plaintext;
	}
});

$twist->setTestFunction(function($items){
	var_dump($items);
});

$twist->start();

$twist->setPushMessage($token, $target, "New List Item");

?>