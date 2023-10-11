<?php 
namespace Webwarrd\Core;

use Webwarrd\Core\Route;
use Webwarrd\Core\Response;
use Webwarrd\Core\Application;
use Webwarrd\Core\Security;

class Router
{
    public $routes;

    public function __construct()
    {
        $this->routes = [];

    }

    public function loadRoutes($routes)
    {
        if(count($routes) > 0)
        {
            foreach($routes as $name => $params)
            {
                array_push($this->routes, new Route($name, $params));
            }
        }
    }

    public function getRouteByUri($uri)
    {
        if(count($this->routes) > 0)
        {
            foreach($this->routes as $route)
            {
                if($route->match($uri, "uri"))
                {
                    return $route;
                }
            }
        }

        return NULL;
    }

    public function redirect($name)
    {
        if(count($this->routes) > 0)
        {
            foreach($this->routes as $route)
            {
                if($route->match($name, "name"))
                {
                    header("Location:" . $route->uri);
                    exit();
                }
            }
        }
    }

    public function process($request)
    {
        $route = $this->getRouteByUri($request->uri());

        if($route)
        {
            try
            {
                if($route->firewall)
                {
                    if(!Security::checkAuth())
                    {
                        $this->redirect("login");
                    }
                }

                $class = "App\\Account\\Controller\\" . $route->controller . "Controller";
                $controller = new $class($this);
                $handler = $route->handler;

                Application::$response->setStatusCode(200);
                Application::$response->setBody($controller->$handler()); 
            }
            catch(\Trowable $e)
            {
                Application::$response->setStatusCode($e->getCode());
                Application::$response->setBody($e->getMessage());   
            }
        }
        else
        {
            Application::$response->setStatusCode(404);
            Application::$response->setBody("Page was not found");        
        }
    }
}