<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/routes.php';

use Webwarrd\Core\Application;

$app = new Application(__DIR__);

$app->router->loadRoutes($routes);

$app->run();