<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/10/23
 * Time: 5:27 PM
 * Return:
 */

namespace common\lib;


class Request
{
    public function get($key = null)
    {
        if ($key !== null) {
            return isset($_GET[$key]) ? $_GET[$key] : null;
        }
        return $_GET;
    }

    public function post($key = null)
    {
        if ($key !== null) {
            return isset($_POST[$key]) ? $_POST[$key] : null;
        }
        return $_POST;
    }

    public function input($key = null)
    {
        if ($key !== null) {
            return isset($_REQUEST[$key]) ? $_REQUEST[$key] : null;
        }
        return $_REQUEST;
    }
}