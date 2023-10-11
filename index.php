<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/routes.php';
require_once __DIR__ . '/config/config.php';

use Webwarrd\Core\Application;

$app = new Application(__DIR__, $config);

$app->router->loadRoutes($routes);

$app->run();