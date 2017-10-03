<?php

use Wouterds\IkHaat\Application\Container;
use Wouterds\IkHaat\Application\Http\Application;
use Wouterds\IkHaat\Infrastructure\View\Twig;

// Application directory
define('APP_DIR', dirname(__DIR__));

// Include composer autoloader
require_once (APP_DIR . '/vendor/autoload.php');

// Load container
$container = Container::load();

// Init http app
$app = new Application();

// Run http app
$app->run();
