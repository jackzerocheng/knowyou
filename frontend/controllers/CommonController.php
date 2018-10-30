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
use common\models\UserModel;

class CommonController extends Controller
{
    public $userId;
    public $username;
    public $status;
    public $redisSession;//uid,time,ip

    public $requireLogin = true;

    public function init()
    {
        parent::init();

        //要求登录态访问
        if ($this->requireLogin) {
            $nowIP = getIP();
            $userModel = new UserModel();
            //获取session
            if (!$this->userId = $userModel->getSession()) {
                //获取cookie
                $cookie = Yii::$app->response->cookies;
                if ($cookie->has($userModel::COOKIE_USER_INFO)) {
                    //cookie自动登录
                    $userModel->loginByCookie();
                }

                if (!$this->userId = $userModel->getSession()) {
                    Yii::warning("try to login by cookie failed!login_ip:{$nowIP}", CATEGORIES_WARN);
                    Yii::$app->session->setFlash('failed', '登录后再访问');
                    return Yii::$app->response->redirect(['login/index']);
                }

                Yii::info("login by cookie success!uid:{$this->userId}", CATEGORIES_INFO);
            }

            $redisSession = $userModel->getRedis($this->userId);
            if (!$redisSession) {
                Yii::warning("cannot find redis info;uid:{$this->userId}", CATEGORIES_WARN);
                $this->removeSession();
                Yii::$app->session->setFlash('failed', '登录失效，请重新登录');
                return Yii::$app->response->redirect(['login/index']);
            }
            //验证当前IP和登录时记录IP是否一致
            if ($nowIP != $redisSession['login_ip']) {
                Yii::warning("force to logout because of ip diff;old_ip:{$redisSession['login_ip']};now_ip:{$nowIP};uid:{$this->userId}", CATEGORIES_WARN);
                $this->removeSession();
                Yii::$app->session->setFlash('failed', '你已在别处登录，请重新登录');
                return Yii::$app->response->redirect(['login/index']);
            }

            $this->redisSession = $redisSession;

            $userInfo = $userModel->getOneByCondition($this->userId);
            $this->username = $userInfo['username'];
            $this->status = $userInfo['status'];
        }

        return true;

    }

    public function removeSession()
    {
        Yii::$app->session->remove(UserModel::SESSION_USE_ID);
        Yii::$app->session->destroy();
        return true;
    }
}