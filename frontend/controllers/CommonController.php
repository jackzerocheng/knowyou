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

    public $requireLogin = true;

    public function init()
    {
        parent::init();

        if ($this->requireLogin) {
            //要求登录态访问
            //获取session
            if (!$this->getSession()) {
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
        }

        return true;

    }

    private function getSession()
    {
        $session = Yii::$app->session;
        return $session->get(LoginForm::SESSION_USE_ID);
    }
}