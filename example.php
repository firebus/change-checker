<?php

function __autoload($class) {
	$class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
	$file = __DIR__ . "/library/$class.php";
	error_log($file);
	if (is_file($file)) {
		require_once(__DIR__ . "/library/$class.php");
	}
}

$detectorsConfiguration = array(
	'Page' => array(
		array('resource' => 'http://example.com/secret-blog', 'id' => 'example-page'),
	),
	'Twitter' => array(
		array('resource' => 'exampleScreenname', 'id' => 'example-screenname'),
	),
);
$alwaysAlertList = array('admin@example.org');
$changeAlertList = array('someguy@example.com');
$searchString = 'fascinating topic';

\firebus\Logger\Logger::setDebug(TRUE);

$changeChecker = new \firebus\ChangeChecker\ChangeChecker($detectorsConfiguration, $alwaysAlertList, $changeAlertList, $searchString);
$changeChecker->check();