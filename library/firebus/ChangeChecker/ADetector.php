<?php

namespace firebus\ChangeChecker;

/**
 * Abstract change detector
 */
abstract class ADetector {
	protected $changeFile;
	protected $resource;
	
	public function __construct($resource, $id){
		$this->resource = $resource;
		$this->changeFile = "$id";
	}

	abstract public function detect();

	protected function storeLastChange($lastChange) {
		file_put_contents($this->changeFile, $lastChange);
	}

	protected function retrieveLastChange() {
		if (is_file($this->changeFile)) {
			return file_get_contents($this->changeFile);
		} else {
			return '';
		}
	}
}