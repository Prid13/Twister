<?php

include("vendor/advanced_html_dom.php");

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
	public $hasRun;

	public function __construct($url, $min_name = null){
		$this->url = $url;
		$this->min_name = is_null($min_name) ? urlencode(basename($url)) : $min_name;
		$this->hasRun = false;
	}
	
	public function start(){		
		$setupLoad = $this->startSetup();
		
		if($setupLoad){
			$this->saveDifferences();
			$this->hasRun = true;
			
			if(isset($this->pushMessageArray)){
				$this->sendPushMessageInternal();
			}
		}
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
			
			return true;
		} else {
			return false;
		}
	}
	
	private function saveDifferences(){
		$diffTxt = array_diff_once($this->items, $this->items_saved);
		
		if($this->firstRead || count($diffTxt) > 0){
			$text = "";
			
			if(count($this->items_saved) > 0){
				foreach($diffTxt as $item){
					$text .= $item . "\r\n";
				}
			} else {
				$i = 0;
				$count = count($diffTxt)-1;
				foreach($diffTxt as $item){
					if($i++ < $count)
						$text .= $item . "\r\n";
					else
						$text .= $item;
				}
			}
			
			$this->diffTxt = $diffTxt;
			
			$filepath = 'db/' . $this->min_name . '.txt';
			
			if(!$this->firstRead)
				$text = $text . file_get_contents($filepath);
			
			$fp = fopen($filepath, 'w');
			fwrite($fp, $text);
			fclose($fp);
		}
	}
	
	public function setPushMessage($token, $target, $title){
		$this->pushMessageArray = array("token" => $token, "target" => $target, "title" => $title);
		
		if($this->hasRun)
			$this->sendPushMessageInternal();
	}
	
	private function sendPushMessageInternal(){
		$twists = count($this->diffTxt);

		if($twists > 0){
			$pb = new Pushbullet($this->pushMessageArray["token"]);
			$pb->pushNote($this->pushMessageArray["target"], $this->pushMessageArray["title"] . " ($twists)", implode("\r\n", $this->diffTxt));
		}
	}
	
	public function setQPushMessage($name, $code, $title){
		$twists = count($this->diffTxt);
		
		if($twists > 0){
			curl_setopt_array($ch = curl_init(), array(
			  CURLOPT_URL => "https://qpush.me/pusher/push_site/",
			  CURLOPT_POSTFIELDS => array(
				"name" => $name,
				"code" => $code,
				"cache" => "false",
				"msg[text]" => $title . " ($twists)\r\n\r\n" . implode("\r\n", $this->diffTxt)
			  ),
			  CURLOPT_RETURNTRANSFER => true,
			));
			curl_exec($ch);
			curl_close($ch);
		}
	}
	
	public function setGroupMeMessage($access_token, $bot_id, $title){
		$twists = count($this->diffTxt);
		
		if($twists > 0){
			require('groupme.php');

			$gm = new GroupMePHP\groupme($access_token);
			$gm->bots->post(array(
				"bot_id" => $bot_id,
				"text" => $title . " ($twists)\r\n\r\n" . implode("\r\n", $this->diffTxt)
			));
		}
	}
	
	public function errorHandler($msg){
		echo "<p><b>ERROR:</b> " . $msg . "</p>";
	}
	
}

?>