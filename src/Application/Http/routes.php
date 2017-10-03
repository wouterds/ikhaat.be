<?php

use Wouterds\IkHaat\Application\Http\Application;
use Wouterds\IkHaat\Application\Http\Handlers\HomeHandler;

/** @var Application $app */

$app->get('/', HomeHandler::class)->setName('home');
