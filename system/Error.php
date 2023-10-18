<?php
namespace Webwarrd\Core;

class Error
{
    private static $messages = [];

    public static function add($message)
    {
        array_push(self::$messages, $message);
    }

    public static function list()
    {
        return self::$messages;
    }

    public static function is()
    {
        return count(self::$messages) > 0; 
    }
}