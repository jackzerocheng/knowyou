<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/10/24
 * Time: 7:51 PM
 * Return:
 */

namespace api\controllers;

use common\lib\Request;
use common\models\UserModel;
use Yii;

class RegisterController extends CommonController
{
    public function actionIndex()
    {
        $needKeys = ['username', 'password'];
        $params = (new Request)->post();

        foreach ($params as $k => $v) {
            if (!isset($v) || !in_array($k, $needKeys)) {
                unset($params[$k]);
            }
        }

        if (!empty(array_diff($needKeys, array_keys($params)))) {
            $this->outputJson('params_error');
        }

        if ((new UserModel())->getCountByCondition(['username' => $params['username']]) > 0) {
            $this->outputJson('repeat_username');
        }

        $data = [
            'username' => $params['username'],
            'password' => $params['password']
        ];
        if (!$uid = (new UserModel())->register($data)) {
            $ip = getIP();
            Yii::warning("register failed;username:{$params['username']};register_ip:{$ip}", CATEGORIES_WARN);
            $this->outputJson('register_failed');
        }
        Yii::info("user register success;uid:{$uid}", CATEGORIES_INFO);

        $this->success(['uid' => $uid]);
    }
}