<?php
namespace Webwarrd\Core;

use Webwarrd\Core\Request;
use Webwarrd\Core\Response;
use Webwarrd\Core\Router;

class Application{
    public static $rootDir;
    public $request;
    public $response;
    public $router;

    public function __construct($rootDir)
    {
        self::$rootDir = $rootDir;
        $this->request = new Request();
        $this->router = new Router();
    }

    public function run()
    {
        $this->router->process($this->request);
    }
}