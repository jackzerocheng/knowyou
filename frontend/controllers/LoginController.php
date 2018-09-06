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

class LoginController extends CommonController
{
    public $layout = 'login';

    public function actionIndex()
    {
        $userModel = new User();

        return $this->render('index', ['model' => $userModel]);
    }

    public function actionLogin()
    {
        $user = new User();
        $params = Yii::$app->request->post();
        if (Yii::$app->request->isPost && $user->login($params['User'])) {
            return $this->redirect(['Home/index']);
        }

        return $this->render('index', ['model' => $user]);
    }

    public function actionRegister()
    {
        $user = new User();

        if (Yii::$app->request->isPost && $user->load(Yii::$app->request->post()) && $user->register()) {
            Yii::$app->session->setFlash('success', '注册用户成功');
            return $this->redirect(['index']);
        }

        return $this->render('register', ['model' => $user]);
    }
}