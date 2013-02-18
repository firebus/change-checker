<?php

function __autoload($class) {
	$class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
	$file = __DIR__ . "/library/$class.php";
	if (is_file($file)) {
		require_once(__DIR__ . "/library/$class.php");
	}
}

$changeDetectorsConfiguration = array(
	array('type' => 'Page', 'resource' => 'http://example.com/secret-blog', 'id' => 'secret-blog'),
	array('type' => 'Twitter', 'resource' => 'example', 'id' => 'example'),
);
$alwaysAlertList = array('admin@example.org');
$changeAlertList = array('someguy@example.com');
$searchString = 'fascinating topic';

\firebus\logger\Logger::setDebug(TRUE);

$changeChecker = new \firebus\change_checker\ChangeChecker($changeDetectorsConfiguration, $alwaysAlertList, $changeAlertList, $searchString);
$changeChecker->check();