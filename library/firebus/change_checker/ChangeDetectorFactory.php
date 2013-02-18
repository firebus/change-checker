<?php

namespace firebus\change_checker;

/**
 * Base ChangeDetector class
 */
class ChangeDetectorFactory {
	public static function create($type, $resource, $id) {
		$cdClass = "firebus\change_checker\ChangeDetector$type";
		return new $cdClass($resource, $id);
	}
}
