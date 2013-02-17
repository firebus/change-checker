<?php

/**
 * Just a logger class
 */
class Logger {
	const DEBUG = TRUE;
	
	public static function log($message) {
		if (self::DEBUG) {
			error_log($message);
		}
	}
}