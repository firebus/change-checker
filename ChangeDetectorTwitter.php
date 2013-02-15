<?php

require_once('IChangeDetector.php');
require_once('Logger.php');

/**
 * ChangeDetectorTwitter
 */
class ChangeDetectorTwitter implements IChangeDetector {
	private $changeFile;
	private $resource;
	
	public function __construct($resource, $id) {
		$this->resource = $resource;
		$this->changeFile = "twitter-$id";
	}
	
	public function detect() {
		$dom = new DOMDocument;
		$url = $this->makeURL();
		$lastId = $this->retrieveLastChange();
		Logger::log("last id: $lastId");
		$maxId = $lastId;
		$results = array();

		$dom->loadXML(file_get_contents($url));
		foreach ($dom->getElementsByTagName('status') as $status) {
			$ids = $status->getElementsByTagName('id');
			$id = $ids->item(0)->textContent;
			$texts = $status->getElementsByTagName('text');
			$text = $texts->item(0)->textContent;
			Logger::log("processing tweet $id $text");
			if ($id > $lastId) {
				if ($id > $maxId) {
					$maxId = $id;
				}
				$results[] = array('text' => $text, 'url' => $this->makeStatusUrl($id));
			} else {
				Logger::log("$id is not > $lastId");
				break;
			}
		}
		$this->storeLastChange($maxId);
		
		return $results;
	}
	
	private function storeLastChange($lastChange) {
		file_put_contents($this->changeFile, $lastChange);
	}
	
	private function retrieveLastChange() {
		return file_get_contents($this->changeFile);
	}
	
	private function makeURL() {
		return 'https://api.twitter.com/1/statuses/user_timeline.xml?screen_name=' . $this->resource;
	}
	
	private function makeStatusUrl($id) {
		return 'https://twitter.com/' . $this->resource . "/status/$id";
	}
}