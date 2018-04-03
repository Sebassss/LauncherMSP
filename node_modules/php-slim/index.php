<?php
require(__DIR__ . DIRECTORY_SEPARATOR . "slim" . DIRECTORY_SEPARATOR . "Slim" . DIRECTORY_SEPARATOR . "Slim.php");
\Slim\Slim::registerAutoloader();

$module->exports = new \Slim\Slim();
