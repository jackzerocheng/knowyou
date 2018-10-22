<?php
/**
 * Message: 登录  注册  退出
 * User: jzc
 * Date: 2018/9/6
 * Time: 下午10:56
 * Return:
 */

namespace frontend\controllers;

use Yii;
use common\models\UserModel;

class LoginController extends CommonController
{
    public $requireLogin = false;
    public $layout = 'login';

    public function init()
    {
        //登录态则跳回主页
        if (Yii::$app->session->has(UserModel::SESSION_USE_ID)) {
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
        $userModel = new UserModel();

        if (Yii::$app->request->isPost && $userModel->load(Yii::$app->request->post()) && $userModel->validate() && $userModel->login()) {
            return $this->redirect(['site/index']);
        }

        return $this->render('index', ['model' => $userModel]);
    }

    public function actionRegister()
    {
        $userModel = new UserModel();

        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post('LoginForm');

            if ($userModel->validateRegister($params)) {
                $data = [
                    'username' => $params['username'],
                    'password' => setPassword($params['password'])
                ];
                if ($uid = $userModel->register($data)) {
                    Yii::$app->session->setFlash('success', '注册用户成功,账号为' . $uid);
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash('failed', '注册失败');
                }
            }
        }

        return $this->render('register', ['model' => $userModel]);
    }
}