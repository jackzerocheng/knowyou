<?php
namespace frontend\controllers;

use yii\web\Controller;
use common\models\User;
use Yii;

class SiteController extends Controller
{
    public $layout = 'index';

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
