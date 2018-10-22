<?php
/**
 * Message:
 * User: jzc<jzc1@meitu.com>
 * Date: 2018/8/28
 * Time: 下午10:41
 * Return:
 */

namespace backend\controllers;

use Yii;

class LoginController extends CommonController
{
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
        return $this->renderPartial('index');
    }
}