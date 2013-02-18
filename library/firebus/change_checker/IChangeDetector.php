<?php

namespace firebus\change_checker;

/**
 * Define the ChangeDetector Interface
 */
interface IChangeDetector {
	public function __construct($resource, $id);
	public function detect();
}