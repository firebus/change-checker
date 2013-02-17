<?php

function __autoload($class) {
	$class = str_replace('\\', DIRECTOR_SEPARATOR, $class);
	require_once("library/$class.php");
}

$changeDetectorsConfiguration = array(
	array('type' => 'Page', 'resource' => 'http://example.com/secret-blog', 'id' => 'secret-blog'),
	array('type' => 'Twitter', 'resource' => 'example', 'id' => 'example'),
);
$alwaysAlertList = array('admin@example.org');
$changeAlertList = array('someguy@example.com');
$searchString = 'fascinating topic';

$changeChecker = new firebus\change_checker\ChangeChecker($changeDetectorsConfiguration, $alwaysAlertList, $changeAlertList, $searchString);
$changeChecker->check();