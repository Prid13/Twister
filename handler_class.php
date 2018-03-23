<?php

class Handler {

	public $url;
	public $handlerFunc;

	public function __construct($url){
		$this->url = $url;
	}
	
	public function setHandler($anonFunc){
		$this->handlerFunc = $anonFunc;
	}
	
}

?>