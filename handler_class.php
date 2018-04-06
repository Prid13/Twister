<?php

include("vendor/simple_html_dom.php");

class Handler {

	public $url;
	public $initFunc;
	public $handlerFunc;
	public $testFunc;
	private $min_name;
	private $items;
	private $items_saved;
	private $firstRead;
	public $diffTxt;

	public function __construct($url){
		$this->url = $url;
		$this->min_name = urlencode(basename($url));
	}
	
	public function start(){		
		$setupLoad = $this->startSetup();
		
		if($setupLoad)
			$this->saveDifferences();
	}
	
	public function test(){	
		$setupLoad = $this->startSetup();
		
		if($setupLoad){
			$testFunc = $this->testFunc;
			$testFunc($this->items);
		}
	}
	
	private function startSetup(){
		$html = @file_get_html($this->url);
		
		if($html === FALSE){
			$this->errorHandler("Failed to load website: $this->url");
			return false;
		}
		
		$this->items = array();
		$this->firstRead = !$this->readFileContents();
		
		if($this->firstRead){
			if(isset($this->initFunc)){
				$initFunc = $this->initfunc;
				$initFunc($html, $this->items);
			} else {
				$handlerFunc = $this->handlerFunc;
				$handlerFunc($html, $this->items);
			}
		} else {
			$handlerFunc = $this->handlerFunc;
			$handlerFunc($html, $this->items);
		}
		
		return true;
	}
	
	public function setInitFunction($anonFunc){
		$this->initFunc = $anonFunc;
	}
	
	public function setHandler($anonFunc){
		$this->handlerFunc = $anonFunc;
	}
	
	public function setTestFunction($anonFunc){
		$this->testFunc = $anonFunc;
	}
	
	private function readFileContents(){
		$this->items_saved = [];

		$file_exists = file_exists('db/' . $this->min_name . '.txt');
		
		if($file_exists){
			$fp = fopen('db/' . $this->min_name . '.txt', 'r');
			$content = fread($fp, filesize('db/' . $this->min_name . '.txt'));
			fclose($fp);

			$this->items_saved = explode("\r\n", $content);
		} else {
			return false;
		}
	}
	
	private function saveDifferences(){
		$diffTxt = array_diff($this->items_saved, $this->items);
		
		if($this->firstRead || count($diffTxt) > 0){
			$text = "";
			
			for($i = 0; $i < count($this->items)-1; $i++)
				$text .= $this->items[$i] . "\r\n";
			
			$text .= $this->items[count($this->items)-1];
			
			$this->diffTxt = $diffTxt;
			
			$fp = fopen('db/' . $this->min_name . '.txt', 'w');
			fwrite($fp, $text);
			fclose($fp);
		}
	}
	
	public function errorHandler($msg){
		echo "<p><b>ERROR:</b> " . $msg . "</p>";
	}
	
}

?>