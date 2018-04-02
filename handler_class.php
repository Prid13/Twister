<?php

include("vendor/simple_html_dom.php");

class Handler {

	public $url;
	public $initFunc;
	public $handlerFunc;
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
		$html = file_get_html($this->url);
		
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
		
		$this->saveDifferences();
	}
	
	public function setInitFunction($anonFunc){
		$this->initFunc = $anonFunc;
	}
	
	public function setHandler($anonFunc){
		$this->handlerFunc = $anonFunc;
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
		if($this->firstRead || count(array_diff($this->items_saved, $this->items)) > 0){
			$text = "";
			
			for($i = 0; $i < count($this->items)-1; $i++)
				$text .= $this->items[$i] . "\r\n";
			
			$text .= $this->items[count($this->items)-1];
			
			$this->diffTxt = $text;
			
			$fp = fopen('db/' . $this->min_name . '.txt', 'w');
			fwrite($fp, $text);
			fclose($fp);
		}
	}
	
}

?>