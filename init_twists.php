<?php

$path = './twists/';
$files = array_diff(scandir($path), array('.', '..'));

foreach($files as $file){
	if(strtolower(pathinfo($file)['extension'] == "php")){
		
	}
}

?>