<?php

namespace firebus\change_checker;

/**
 * SchedulerFactory
 */
class SchedulerFactory {
	public static function create($type, $detectorCount) {
		$schedulerClass = "firebus\change_checker\Scheduler$type";
		if (class_exists($schedulerClass)) {
			return new $schedulerClass($detectorCount, $type);
		} else {
			return NULL;
		}
	}
}
