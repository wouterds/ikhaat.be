<?php

use Wouterds\IkHaat\Application\Http\Application;
use Wouterds\IkHaat\Application\Http\Handlers\HomeHandler;
use Wouterds\IkHaat\Application\Http\Handlers\ImageHandler;

/** @var Application $app */

$app->get('/', HomeHandler::class)->setName('home');
$app->get('/{text}.jpg', ImageHandler::class)->setName('image');
