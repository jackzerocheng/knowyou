<?php
/**
 * Message: 微信公众号开发者接入
 * User: jzc
 * Date: 2018/12/20
 * Time: 5:51 PM
 * Return:
 */

namespace api\controllers;

use yii\web\Request;
use Yii;

class WeiXinController extends CommonController
{
    public function actionIndex()
    {
        $params = (new Request())->get();

        Yii::warning('wei_xin request:'.json_encode($params), CATEGORIES_WARN);
        $tmpArray = array(WX_TOKEN, $params['timestamp'], $params['nonce']);
        sort($tmpArray, SORT_STRING);
        $tmpStr = implode($tmpArray);
        $tmpStr = sha1($tmpStr);

        if ($params['signature'] == $tmpStr) {
            echo $params['echostr'];
            exit();
        }

        $this->outputJson('failed');
    }
}