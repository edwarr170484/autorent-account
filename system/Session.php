<?php 
namespace Webwarrd\Core;

class Session
{
    public function __get($name)
    {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : NULL;
    }

    public function __set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function remove($name)
    {
        unset($_SESSION[$name]);
    }
}