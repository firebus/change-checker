<?php

namespace firebus\change_checker;

/**
 * DetectorFactory
 */
class DetectorFactory {
	public static function create($type, $resource, $id) {
		$cdClass = "firebus\change_checker\Detector$type";
		return new $cdClass($resource, $id);
	}
}
