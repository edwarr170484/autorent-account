<?php
namespace Webwarrd\Core;

use Webwarrd\Core\Request;
use Webwarrd\Core\Response;
use Webwarrd\Core\Router;

class Application{
    public static $rootDir;
    public static $request;
    public static $response;
    public $router;

    public function __construct($rootDir)
    {
        self::$rootDir = $rootDir;
        self::$request = new Request();
        self::$response = new Response();
        $this->router = new Router();
    }

    public function run()
    {
        $this->router->process(self::$request);
        self::$response->send();
    }
}