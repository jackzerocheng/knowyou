<?php
/**
 * Message: 后台登录页
 * User: jzc
 * Date: 2018/8/28
 * Time: 下午10:41
 * Return:
 */

namespace backend\controllers;

use Yii;
use common\models\AdminModel;

class LoginController extends CommonController
{
    protected $requireLogin = false;

    public function init()
    {
        parent::init();

        if ($this->uid) {
            return Yii::$app->response->redirect(['site/index']);
        }

        return true;
    }

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\captchaAction',
                'maxLength' => 4,
                'minLength' => 4,
                'width' => 80,
                'height' => 40,
            ]
        ];
    }

    public function actionIndex()
    {
        $admin = new AdminModel();
        if (Yii::$app->request->isPost) {

        }

        return $this->renderPartial('index', ['model' => $admin]);
    }
}