<?php

// Application directory
use Wouterds\IkHaat\Application\Http\Application;

define('APP_DIR', dirname(__DIR__));

// Include composer autoloader
require_once (APP_DIR . '/vendor/autoload.php');

// Init http app
$app = new Application();

// Run http app
$app->run();
