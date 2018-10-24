<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/10/23
 * Time: 5:11 PM
 * Return:
 */

namespace api\controllers;

use common\lib\Request;
use common\models\UserModel;
use Yii;

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

        if (!$accessToken = (new UserModel())->getAccessToken($params['uid'], $params['password'], $params['platform_id'])) {
            $ip = getIP();
            Yii::warning("user try to login but failed;uid:{$params['uid']};login_ip:{$ip};platform_id:{$params['platform_id']}", CATEGORIES_WARN);
            $this->outputJson('login_failed');
        }

        Yii::info("user login in;uid:{$params['uid']};", CATEGORIES_INFO);
        $userInfo = (new UserModel())->getOneByCondition($params['uid']);
        unset($userInfo['password']);

        $data = [
            'access_token' => $accessToken,
            'userInfo' => $userInfo
        ];

        $this->success($data);
    }
}