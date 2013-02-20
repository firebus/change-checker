<?php

namespace firebus\change_checker;

/**
 * ChangeDetectorTwitter
 */
class ChangeDetectorTwitter extends AChangeDetector {

	public function __construct($resource, $id) {
		$this->resource = $resource;
		$this->changeFile = "twitter-$id";
	}
	
	public function detect() {
		$dom = new \DOMDocument;
		$url = $this->makeURL();
		$lastId = $this->retrieveLastChange();
		\firebus\logger\Logger::log(\firebus\logger\Logger::DEBUG, "last id: $lastId");
		$maxId = $lastId;
		$results = array();

		$statuses = @file_get_contents($url);
		
		if ($statuses === FALSE) {
			\firebus\logger\Logger::log(\firebus\logger\Logger::WARNING, "failed to get statuses for " . $this->resource);
		} else {
			$dom->loadXML($statuses);
			foreach ($dom->getElementsByTagName('status') as $status) {
				$ids = $status->getElementsByTagName('id');
				$id = $ids->item(0)->textContent;
				$texts = $status->getElementsByTagName('text');
				$text = $texts->item(0)->textContent;
				\firebus\logger\Logger::log(\firebus\logger\Logger::DEBUG, "processing tweet $id $text");
				if ($id > $lastId) {
					if ($id > $maxId) {
						$maxId = $id;
					}
					$results[] = array('text' => $text, 'url' => $this->makeStatusUrl($id));
				} else {
					\firebus\logger\Logger::log(\firebus\logger\Logger::DEBUG, "$id is not > $lastId");
					break;
				}
			}
			$this->storeLastChange($maxId);
		}
		
		return $results;
	}
	
	private function makeURL() {
		return 'https://api.twitter.com/1/statuses/user_timeline.xml?screen_name=' . $this->resource;
	}
	
	private function makeStatusUrl($id) {
		return 'https://twitter.com/' . $this->resource . "/status/$id";
	}
}