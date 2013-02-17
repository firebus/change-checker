<?php

/**
 * Define the ChangeDetector Interface
 */
interface IChangeDetector {
	public function __construct($resource, $id);
	public function detect();
}