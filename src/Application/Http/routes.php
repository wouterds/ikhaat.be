<?php

use Wouterds\KabouterWesley\Application\Http\Application;
use Wouterds\KabouterWesley\Application\Http\Handlers\HomeHandler;
use Wouterds\KabouterWesley\Application\Http\Handlers\ImageHandler;
use Wouterds\KabouterWesley\Application\Http\Middlewares\TwitterBotMiddleware;

/** @var Application $app */

$app->get('/', HomeHandler::class)->setName('home');
$app->get('/{text}.jpg', ImageHandler::class)->setName('image')->add(TwitterBotMiddleware::class);
