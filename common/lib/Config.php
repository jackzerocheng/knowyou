<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/10/23
 * Time: 4:26 PM
 * Return:
 */

namespace common\lib;

use yii\db\Exception;

class Config
{
    public static $fileSuffix = '.php';

    public static function errorLang($file, $key)
    {
        $errorLangPath = dirname(__DIR__) . '/config/error_lang/' . $file . static::$fileSuffix;

        if (!file_exists($errorLangPath)) {
            throw new Exception('can not find error lang file!');
        }

        $data = include $errorLangPath;

        if (!isset($data[$key])) {
            return null;
        }

        $data = $data[$key];

        return $data;
    }
}