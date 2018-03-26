<?php

include("handler_class.php");

$path = './twists/';
$files = array_diff(scandir($path), array('.', '..'));

// remove all files that are NOT PHP
foreach($files as $i => $file){
	if(strtolower(pathinfo($file)['extension'] == "php")){
		include($path . $file);
	}
}



?>