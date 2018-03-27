<?php
session_start();

require('config.php');

$bootstrap = new Bootstrap($_SERVER['REQUEST_URI']);
$controller = $bootstrap->createController();
if($controller){
	$controller->executeAction();
}