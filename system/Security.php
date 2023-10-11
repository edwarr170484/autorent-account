<?php 
namespace Webwarrd\Core;

use Webwarrd\Core\Application;
use Ramsey\Uuid\Uuid;

class Security
{
    public static function checkAuth()
    {
        return Application::$session->userId ?? false;
    }

    public static function auth()
    {
        $uuid = Uuid::uuid4();

        if((Application::$session->phone == Application::$request->post("phone")) && 
            (Application::$session->code == Application::$request->post("code")))
        {
            Application::$session->remove("code");

            Application::$session->userId = $uuid->toString();
            return $uuid->toString();
        }
        
        return false;
    }
}