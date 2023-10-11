<?php
namespace Webwarrd\Core;

class Request
{
    private $get;
    private $post;
    private $files;
    private $request;
    private $server;
    private $session;
    private $uri;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->request = $_REQUEST;
        $this->server = $_SERVER;
        $this->files = $_FILES;
        $this->session = $_SESSION;
        
        $params = explode("?", $_SERVER['REQUEST_URI']);
        $this->uri = $params[0];
    }

    public function get($name)
    {
        return $this->get[$name] ?? NULL;
    }

    public function post($name)
    {
        return $this->post[$name] ?? NULL;
    }

    public function request($name)
    {
        return $this->request[$name] ?? NULL;
    }

    public function server($name)
    {
        return $this->server[$name] ?? NULL;
    }

    public function session($name)
    {
        return $this->session[$name] ?? NULL;
    }

    public function uri()
    {
        return $this->uri;
    }

    public function getMethod()
    {
        return strtolower($this->server('REQUEST_METHOD'));
    }

    public function isAjax()
    {
        return $this->server('HTTP_X_REQUESTED_WITH') && $this->server('HTTP_X_REQUESTED_WITH') === 'XMLHttpRequest';
    }

    public function absoluteUrl()
    {
        $request_protocol = ($this->server('HTTPS') && $this->server('HTTPS') !== 'off') ? 'https' : 'http';
        return $request_protocol . "://{$this->server('HTTP_HOST')}{$this->server('REQUEST_URI')}";
    }

    public function getServerName()
    {
        $request_protocol = ($this->server('HTTPS') && $this->server('HTTPS') !== 'off') ? 'https' : 'http';
        return $request_protocol . "://{$this->server('HTTP_HOST')}"; 
    }
}