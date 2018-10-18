<?php
/**
 * Message: 通用规则
 * User: jzc
 * Date: 2018/9/6
 * Time: 下午11:17
 * Return:
 */

namespace frontend\controllers;

use yii\web\Controller;
use Yii;
use common\models\LoginForm;

class CommonController extends Controller
{
    public $userId;
    public $userName;
    public $status;
    public $loginTime;
    public $loginIp;

    public $requireLogin = true;

    public function init()
    {
        parent::init();
        $redis = Yii::$app->redis;

        //要求登录态访问
        if ($this->requireLogin) {
            //验证IP是否相同
            if ($this->loginIp != $redis->hget(LoginForm::REDIS_KEY_PREFIX . $this->userId, 'ip')) {
                Yii::$app->session->setFlash('failed', '你已在别处登录，请重新登录');
                return Yii::$app->response->redirect(['login/index']);
            }

            //获取session
            if (!$this->userId = $this->getSession()) {
                //获取cookie
                $cookie = Yii::$app->response->cookies;
                if ($cookie->has(LoginForm::COOKIE_USER_INFO)) {
                    //用cookie登录
                    $loginForm = new LoginForm();
                    $loginForm->loginByCookie();
                }

                if (!$this->getSession()) {
                    Yii::$app->session->setFlash('failed', '登录后再访问');
                    return Yii::$app->response->redirect(['login/index']);
                }
            }

            $this->userName = $redis->hget(LoginForm::REDIS_KEY_PREFIX . $this->userId, 'username');
            $this->status = $redis->hget(LoginForm::REDIS_KEY_PREFIX . $this->userId, 'status');
            $this->loginTime = $redis->hget(LoginForm::REDIS_KEY_PREFIX . $this->userId, 'login_time');
            $this->loginIp = $redis->hget(LoginForm::REDIS_KEY_PREFIX . $this->userId, 'ip');
        }

        return true;

    }

    private function getSession()
    {
        $session = Yii::$app->session;
        return $session->get(LoginForm::SESSION_USE_ID);
    }
}