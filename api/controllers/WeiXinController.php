<?php
/**
 * Message: 微信公众号服务调用
 * User: jzc
 * Date: 2018/12/20
 * Time: 5:51 PM
 * Return:
 */

namespace api\controllers;

use yii\web\Request;

class WeiXinController extends CommonController
{
    public function actionIndex()
    {
        $params = (new Request())->get();
        $this->outputJson('success', $params);
    }
}