<?php
/**
 * Message: 登录  注册  退出
 * User: jzc
 * Date: 2018/9/6
 * Time: 下午10:56
 * Return:
 */

namespace frontend\controllers;

use common\models\User;
use Yii;
use common\models\LoginForm;

class LoginController extends CommonController
{
    public $requireLogin = false;
    public $layout = 'login';

    public function init()
    {
        //登录态则跳回主页
        if (Yii::$app->session->has(LoginForm::SESSION_USE_ID)) {
            Yii::$app->session->setFlash('message', '您已登录');
            return Yii::$app->response->redirect(['site/index']);
        }

        return true;
    }

    public function actions()
    {
        //验证码
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'maxLength' => 4,
                'minLength' => 4,
                'width' => 100,
                'height' => 50,
            ]
        ];
    }

    public function actionIndex()
    {
        $loginForm = new LoginForm();
        if (Yii::$app->request->isPost && $loginForm->load(Yii::$app->request->post()) && $loginForm->validate() && $loginForm->login()) {
            return $this->redirect(['site/index']);
        }

        return $this->render('index', ['model' => $loginForm]);
    }

    public function actionRegister()
    {
        $user = new User();

        if (Yii::$app->request->isPost && $user->load(Yii::$app->request->post()) && $user->save()) {
            Yii::$app->session->setFlash('success', '注册用户成功,账号为' . $user::$uid);
            return $this->redirect(['index']);
        }

        return $this->render('register', ['model' => $user]);
    }
}