<?php

class Handler {

	public $url;
	public $initFunc;
	public $handlerFunc;

	public function __construct($url){
		$this->url = $url;
	}
	
	public function start(){
		//$this->initFunc("HELLO WORLD");
		//var_dump($this->initFunc());
	}
	
	public function setInitFunction($anonFunc){
		$this->initFunc = $anonFunc;
	}
	
	public function setHandler($anonFunc){
		$this->handlerFunc = $anonFunc;
	}
	
}

?>