<?php

// HANDY ARRAY FUNCTIONS

function array_diff_once($array1, $array2) {
	foreach($array2 as $a) {
		$pos = array_search($a, $array1);
		if($pos !== false) {
			unset($array1[$pos]);
		}
	}

	return $array1;
}

?>