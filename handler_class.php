<?php

class Handler {

	public $url;
	public $initFunc;
	public $handlerFunc;

	public function __construct($url){
		$this->url = $url;
	}
	
	public function start(){
		call_user_func($this->initFunc, "HELLO WORLD");
	}
	
	public function setInitFunction($anonFunc){
		$this->initFunc = $anonFunc;
	}
	
	public function setHandler($anonFunc){
		$this->handlerFunc = $anonFunc;
	}
	
}

?>