<?php

namespace firebus\ChangeChecker;

/**
 * SchedulerFactory
 */
class SchedulerFactory {
	public static function create($type, $detectorCount) {
		$schedulerClass = __NAMESPACE__ . "\\Scheduler$type";
		if (class_exists($schedulerClass)) {
			return new $schedulerClass($detectorCount, $type);
		} else {
			return NULL;
		}
	}
}
