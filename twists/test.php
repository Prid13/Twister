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

$twist->setQPushMessage($pushName, $pushCode, "New List Item");

//var_dump($twist->diffTxt);

//$twist->setPushMessage($token, $target, "New List Item");

/*curl_setopt_array($ch = curl_init(), array(
  CURLOPT_URL => "https://qpush.me/pusher/push_site/",
  CURLOPT_POSTFIELDS => array(
    "name" => "prid_iphone2",
    "code" => "351566",
    "msg[text]" => "hello world",
  ),
  CURLOPT_RETURNTRANSFER => true,
));
curl_exec($ch);
curl_close($ch);*/

?>