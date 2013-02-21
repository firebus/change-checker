<?php

namespace firebus\change_checker;

/**
 * DetectorFactory
 */
class DetectorFactory {
	public static function create($type, $resource, $id) {
		$detectorClass = "firebus\change_checker\Detector$type";
		return new $detectorClass($resource, $id);
	}
}
