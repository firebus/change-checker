<?php

namespace firebus\ChangeChecker;

/**
 * Abstract base class for Schedulers
 */
abstract class AScheduler {
	
	protected $detectorCount;
	protected $runTimeFile;
	
	public function __construct($detectorCount, $type) {
		$this->detectorCount = $detectorCount;
		$this->runTimeFile = "$type-runtime";
	}
	
	abstract public function schedule();
	
	protected function setRunTime($runTime) {
		file_put_contents($this->runTimeFile, $runTime);
	}
	
	protected function getRunTime() {
		if (is_file($this->runTimeFile)) {
			return file_get_contents($this->runTimeFile);
		} else {
			return 0;
		}
	}
		
}