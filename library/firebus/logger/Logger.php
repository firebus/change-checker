<?php

/**
 * Just a logger class.
 */
class Logger {
	private static $logger = NULL;
	private static $debug = FALSE;
	
	const DEBUG = 1;
	const INFO = 2;
	const WARNING = 2;
	const FATAL = 3;
	
	private function __construct() {}
	
	public static function getLogger() {
		if (self::$logger) {
			return self::$logger;
		} else {
			self::$logger = new Logger();
			return self::$logger;
		}
	}

	public static function setDebug($debug) {
		$self::$debug = $debug;
	}
	
	public function log($level, $message) {
		if ($level > 1 || self::$debug) {
			error_log($message);
		}
	}
}