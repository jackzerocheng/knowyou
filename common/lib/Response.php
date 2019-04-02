<?php
/**
 * Message: http请求响应
 * User: jzc
 * Date: 2018/10/23
 * Time: 4:52 PM
 * Return:
 */

namespace common\lib;


class Response
{
    public static function json($data)
    {
        ob_clean();
        header('Content-type:application/json;charset=utf-8');
        echo json_encode($data, JSON_PARTIAL_OUTPUT_ON_ERROR);

        exit();
    }
}