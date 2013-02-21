<?php

namespace firebus\change_checker;

/**
 * Abstract base class for Schedulers
 */
abstract class AScheduler {
	
	abstract public function schedule();
	
	private function setRunTime($runTimeFile) {
		file_put_contents($runTimeFile, time());
	}
	
	private function getRunTime($runTimeFile) {
		if (is_file($runTimeFile)) {
			return file_get_contents($runTimeFile);
		} else {
			return 0;
		}
	}
		
}