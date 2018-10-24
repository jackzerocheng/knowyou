<?php
/**
 * Message: 读取config中的内容
 * User: jzc
 * Date: 2018/10/23
 * Time: 4:26 PM
 * Return:
 */

namespace common\lib;

use yii\base\Exception;

class Config
{
    /**
     * 获取错误码文件中的对应key数据
     * @param $file
     * @param $key
     * @return mixed|null
     * @throws Exception
     */
    public static function errorLang($file, $key)
    {
        $errorLangPath = dirname(__DIR__) . '/config/error_lang/' . $file . '.php';

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

    /**
     * 读取密钥内容
     * @param $key
     * @return bool|string
     * @throws Exception
     */
    public static function getPem($key)
    {
        $pemFile = dirname(dirname(__DIR__)) . '/environments/' . YII_ENV . '/pem/' . $key . '.pem';

        if (!file_exists($pemFile)) {
            throw new Exception('can not find pem file');
        }

        return file_get_contents($pemFile);
    }
}