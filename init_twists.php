<?php

include("handler_class.php");
include("vendor/pushbullet.php");

// Pushbullet
$token = "o.xrTVjS4nwDFgLc8qcpFLMq2WFWdpVbKX";
$target = "ujyhZW3We84sjz99WkCibI";

$path = './twists/';
$files = array_diff(scandir($path), array('.', '..'));

// remove all files that are NOT PHP
foreach($files as $i => $file){
	if(strtolower(pathinfo($file)['extension'] == "php")){
		include($path . $file);
	}
}



?>