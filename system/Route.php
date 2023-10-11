<?php
namespace Webwarrd\Core;

class Route
{
    public $name;
    public $uri;
    public $controller;
    public $handler;
    public $firewall;

    public function __construct($name, $params)
    {
        $this->name = $name;
        $this->uri = $params["uri"];
        $this->controller = $params["controller"];
        $this->handler = $params["handler"];
        $this->firewall = $params["firewall"];
    }

    public function match($value, $param)
    {
        return $this->$param === $value;
    }
}