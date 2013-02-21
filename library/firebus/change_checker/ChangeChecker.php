<?php

namespace firebus\change_checker;

/**
 * This is the main class. It registers Detectors, parses their results for changes, and alerts if necessary
 */

class ChangeChecker {
	/** @var array people to alert on all changes, for debug purposes */
	private $alwaysAlertList;
	/** @var array people to alert on all matches */
	private $changeAlertList;
	/** @var string text to search for in changes */
	private $searchString;
	/** @var array detectors to check, keyed by type */
	private $detectorCollection = array();
	/** @var array schedulers to consult, keyed by type */
	private $schedulerCollection = array();
	
	/**
	 * Constructor
	 * 
	 * @param array $detectorsConfiguration configures your detectors. It's an array keyed by detector type
	 * Each type is an array of detector configurations (so you can spin up more than one detector of each type)
	 * Each detector configuration has these keys:
	 * - resource: (e.g. a full URL or twitter screen name) in a format that the given Detector type will understand
	 * - id: a unique string to identify this Detector. Will be used when constructing a save file
	 * @param array $alwaysAlertList email addresses to alert on all checks
	 * @param array $changeAlertList email addresses to alert on each change that matches the search string
	 * @param string $searchString an string to search for in changes
	 */
	public function __construct($detectorsConfiguration, $alwaysAlertList, $changeAlertList, $searchString) {
		list($this->alwaysAlertList, $this->changeAlertList, $this->searchString) =
			array($alwaysAlertList, $changeAlertList, $searchString);
		foreach ($detectorsConfiguration as $type => $detectors) {
			foreach ($detectors as $detector) {
				$this->detectorCollection[$type][] = DetectorFactory::create($type, $detector['resource'], $detector['id']);
			}
			$schedulerClass = "firebus\change_checker\Scheduler$type";
			if (class_exists($schedulerClass)) {
				$this->schedulerCollection[$type] = new $schedulerClass;
			} else {
				
			}
		}
	}
	
	public function check() {
		$results = array();
		foreach ($this->detectorCollection as $type => $detectors) {
			if (!array_key_exists($type, $this->schedulerCollection) || $this->schedulerCollection[$type]->schedule()) {
				foreach ($detectors as $detector) {
					$results += $detector->detect();
				}
			}
		}
		
		foreach ($results as $result) {
			\firebus\logger\Logger::log(\firebus\logger\Logger::DEBUG, "checking " . $result['text']);
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