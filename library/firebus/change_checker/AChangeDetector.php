<?php

namespace firebus\change_checker;

/**
 * Abstract change detector
 */
abstract class AChangeDetector {
	protected $changeFile;
	protected $resource;
	
	abstract public function __construct($resource, $id);
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