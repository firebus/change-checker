<?php

namespace firebus\change_checker;

/**
 * Abstract base class for Schedulers
 */
abstract class AScheduler {
	
	
	
	public function setRunTime($runTimeFile) {
		file_put_contents($runTimeFile, time());
	}
	
	public function getRunTime($runTimeFile) {
		if (is_file($runTimeFile)) {
			return file_get_contents($runTimeFile);
		} else {
			return 0;
		}
	}
		
}