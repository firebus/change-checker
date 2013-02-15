<?php

require_once('ChangeDetectorPage.php');
require_once('ChangeDetectorTwitter.php');

/**
 * Base ChangeDetector class
 */
class ChangeDetectorFactory {
	public static function create($type, $resource, $id) {
		$cdClass = "ChangeDetector$type";
		return new $cdClass($resource, $id);
	}
}
