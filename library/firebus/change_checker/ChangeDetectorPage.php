<?php

/**
 * ChangeDetectorPage
 */
class ChangeDetectorPage implements firebus\change_checker\IChangeDetector {
	private $changeFile;
	private $resource;
	
	public function __construct($resource, $id) {
		$this->resource = $resource;
		$this->changeFile = "page-$id";
	}
	
	public function detect() {
		firebus\logger\Logger::log(firebus\logger\Logger::DEBUG, "processing " . $this->resource);
		$lastChange = $this->retrieveLastChange();
		$page = file_get_contents($this->resource);
		$results = array();

		$comparison = stephen_morley\diff\Diff::toString(stephen_morley\diff\Diff::compare($lastChange, $page));
		$lines = explode('\n', $comparison);
		$diff = '';
		foreach ($lines as $line) {
			if (strpos($line, '+') === 0) {
				$diff .= "$line\n";
			}
		}
		if ($diff) {
			$results[] = array('text' => $diff, 'url' => $this->resource);
			$this->storeLastChange($page);
		}
		
		return $results;
	}
	
	private function storeLastChange($lastChange) {
		file_put_contents($this->changeFile, $lastChange);
	}
	
	private function retrieveLastChange() {
		return file_get_contents($this->changeFile);
	}
}