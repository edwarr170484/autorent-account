<?php
namespace Webwarrd\Core;

use Webwarrd\Core\Request;
use Webwarrd\Core\Response;
use Webwarrd\Core\Router;
use Webwarrd\Core\Session;

class Application{
    public static $rootDir;
    public static $request;
    public static $response;
    public static $session;
    public static $config;
    public $router;


    public function __construct($rootDir, $config)
    {
        self::$rootDir = $rootDir;
        self::$request = new Request();
        self::$response = new Response();
        self::$session = new Session();
        self::$config = $config;
        $this->router = new Router();
    }

    public static function getRouter()
    {
        return $this->router;
    }

    public function run()
    {
        $this->router->process(self::$request);
        self::$response->send();
    }
}