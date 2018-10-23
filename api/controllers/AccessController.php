<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/10/23
 * Time: 5:11 PM
 * Return:
 */

namespace api\controllers;

use Yii;
use common\lib\Request;
use common\models\UserModel;

class AccessController extends CommonController
{
    public function actionIndex()
    {
        $needKeys = ['platform_id', 'uid', 'password'];
        $params = (new Request)->post();

        foreach ($params as $k => $v) {
            if (!isset($v) || !in_array($k, $needKeys)) {
                unset($params[$k]);
            }
        }

        if (!empty(array_diff($needKeys, array_keys($params)))) {
            $this->outputJson('params_error');
        }


    }
}