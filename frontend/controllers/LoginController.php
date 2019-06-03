<?php
/**
 * Message: 登录  注册  退出
 * User: jzc
 * Date: 2018/9/6
 * Time: 下午10:56
 * Return:
 */

namespace frontend\controllers;

use common\lib\CryptAes;
use common\models\System\SessionModel;
use Yii;
use common\models\UserModel;

class LoginController extends CommonController
{
    public $requireLogin = false;
    public $layout = 'login';

    public function init()
    {
        parent::init();

        //登录态则跳回主页
        if ((new SessionModel())->getUidSession()) {
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

    //登录
    public function actionIndex()
    {
        $userModel = new UserModel();

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post('UserModel');

            if (!empty($data['uid']) && !empty($data['password'])) {
                $data['password'] = (new CryptAes(USER_AES_KEY))->encrypt(base64_decode($data['password']));

                $rs = $userModel->login($data['uid'], $data['password'], $data['remember']);
                if ($rs) {
                    return $this->redirect(['site/index']);
                }
            }

            Yii::warning("user_login_failed;msg:".json_encode($data), CATEGORIES_WARN);
        }

        return $this->render('index', ['model' => $userModel]);
    }

    //注册
    public function actionRegister()
    {
        $userModel = new UserModel();

        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post('UserModel');

            if ($userModel->validateRegister($params)) {
                $data = [
                    'username' => $params['username'],
                    'password' => (new CryptAes(USER_AES_KEY))->encrypt($params['password'])
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