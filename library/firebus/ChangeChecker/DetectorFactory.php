<?php

namespace firebus\ChangeChecker;

/**
 * DetectorFactory
 */
class DetectorFactory {
	public static function create($type, $resource, $id) {
		$detectorClass = __NAMESPACE__ . "\\Detector$type";
		return new $detectorClass($resource, $id);
	}
}
