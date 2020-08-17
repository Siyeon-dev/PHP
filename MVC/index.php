<?php
// <<-- print PHP Syntax error
error_reporting(E_ALL);
ini_set("display_errors", 1);
// -->> print PHP Syntax error

include './controllers/controller.php';

$controller = new Controller();
$view = $controller->runController();
