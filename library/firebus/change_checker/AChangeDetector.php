<?php

namespace firebus\change_checker;

/**
 * Abstract change detector
 */
abstract class AChangeDetector {
	protected $changeFile;
	protected $runtimeFile;
	protected $resource;
	
	public function __construct($resource, $id){
		$this->resource = $resource;
		$this->changeFile = "$id";
		$this->runtimeFile = "$id-runtime";
	}

	abstract public function detect();

	protected function storeLastChange($lastChange) {
		file_put_contents($this->changeFile, $lastChange);
		file_put_contents($this->runtimeFile, time());
	}

	protected function retrieveLastTime() {
		if (is_file($this->runtimeFile)) {
			return file_get_contents($this->runtimeFile);
		} else {
			return 0;
		}
	}
	
	protected function retrieveLastChange() {
		if (is_file($this->changeFile)) {
			return file_get_contents($this->changeFile);
		} else {
			return '';
		}
	}
}