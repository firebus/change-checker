<?php

/**
 * This is the main class. It registers ChangeDetectors, parses their results for changes, and alerts if necessary
 * TODO: All the hard-coded parameters here should be loaded from a configuration file
 * TODO: Use a frickin' autoloader and put shit in libraries, sheesh what are you lazy?
 */

require_once('ChangeDetectorFactory.php');
require_once('Logger.php');

class ChangeChecker {
	/** @var array people to alert on all changes, for debug purposes */
	private $alwaysAlertList = array('admin@example.org');
	private $changeAlertList = array('someguy@example.com');
	private $searchString = 'fascinating topic';
	private $changeDetectorsConfiguration = array(
		array('type' => 'Page', 'resource' => 'http://example.com/secret-blog', 'id' => 'secret-blog'),
		array('type' => 'Twitter', 'resource' => 'example', 'id' => 'example'),
	);
	private $changeDetectorCollection = array();
	
	public function __construct() {
		foreach ($this->changeDetectorsConfiguration as $cd) {
			$this->changeDetectorCollection[] = ChangeDetectorFactory::create($cd['type'], $cd['resource'], $cd['id']);
		}
	}
	
	public function check() {
		$results = array();
		foreach ($this->changeDetectorCollection as $cd) {
			$results += $cd->detect();
		}
		
		foreach ($results as $result) {
			Logger::log("checking " . $result['text']);
			if (stripos($result['text'], $this->searchString) !== FALSE) {
				$message = "A change at $result[url] contained the search string $this->searchString. We thought you'd like to know.";
				$this->alert($this->changeAlertList, $message);
			}
			$message = "We processed $result[url]. We thought you'd like to know.";
			$this->alert($this->alwaysAlertList, $message);
		}
	}
	
	private function alert($recipients, $message) {
		foreach ($recipients as $recipient) {
			mail($recipient, '[ChangeChecker] Change detected!', $message);
		}
	}
}