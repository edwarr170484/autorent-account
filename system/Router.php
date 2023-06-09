<?php 
namespace Webwarrd\Core;

use Webwarrd\Core\Route;
use Webwarrd\Core\Response;
use Webwarrd\Core\Application;

class Router
{
    public array $routes;
    private $response;

    public function loadRoutes($routes)
    {
        if(count($routes) > 0)
        {
            foreach($routes as $name => $params)
            {
                array_push($routes, new Route($name, $route));
            }
        }
    }

    public function getRouteByUri($uri)
    {
        if(count($routes) > 0)
        {
            foreach($routes as $route)
            {
                if($route->match($uri, "uri"))
                {
                    return $route;
                }
            }
        }

        return NULL;
    }

    public function process($request)
    {
        if($this->getRouteByUri($request->uri()))
        {

        }
        else
        {
            Application::$response->setStatusCode(404);
            Application::$response->setBody("Page was not found");        
        }
    }
}