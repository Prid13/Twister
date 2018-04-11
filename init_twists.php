<?php

header('Content-Type: text/html; charset=utf-8');

include("handler_class.php");
include("vendor/pushbullet.php");
include("functions/array.functions.php");

// Pushbullet
$token = "o.xrTVjS4nwDFgLc8qcpFLMq2WFWdpVbKX";
$target = "ujyhZW3We84sjz99WkCibI";

// QPush
$pushName = "prid_iphone2";
$pushCode = "351566";

// GroupMe
$access_token = "0yeXei20AnoeRsmvSIL16tQeAwkhmtIbPoRO2mtg";

$path = './twists/';
$files = array_diff(scandir($path), array('.', '..'));

// remove all files that are NOT PHP
foreach($files as $i => $file){
	if(strtolower(pathinfo($file)['extension'] == "php")){
		include($path . $file);
	}
}

?>