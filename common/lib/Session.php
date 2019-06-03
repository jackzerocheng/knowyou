<?php
/**
 * Message: PHP Session操作
 * User: jzc
 * Date: 2019/6/3
 * Time: 3:13 PM
 * Return:
 */

namespace common\lib;


class Session
{
    public static function createSession($key, $value)
    {
        session_start();

        $_SESSION[$key] = $value;
        return true;
    }

    public static function getSession($key)
    {
        return !empty($_SESSION[$key]) ? $_SESSION[$key] : '';
    }

    public static function removeSession($key)
    {
        unset($_SESSION[$key]);
        session_destroy();
        return true;
    }
}