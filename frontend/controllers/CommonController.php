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
use common\lib\Config;
use common\lib\Response;

class CommonController extends Controller
{
    public $userId;
    public $userInfo;
    public $redisSession;//uid,time,ip

    public $requireLogin = false;
    public $apiCheckLogin = false;//ajax请求
    public $errorCodeFile = 'frontErrorCode';

    public function init()
    {
        /*
        * 记录每次请求信息
        */
        $moduleName = Yii::$app->controller->module->id;
        $controllerName = Yii::$app->controller->id;
        $actionName = Yii::$app->controller->action->id;
        Yii::info("Request Route:".$moduleName.'/'.$controllerName.'/'.$actionName.';Client IP:'.getIP(), CATEGORIES_ACCESS);


        //要求登录态访问
        if ($this->requireLogin) {
            $this->checkLogin();
        }

        //api检测
        if ($this->apiCheckLogin) {
            $this->apiCheckLogin();
        }

    }

    public function removeSession()
    {
        Yii::$app->session->remove(UserModel::SESSION_USE_ID);
        Yii::$app->session->destroy();
        return true;
    }

    public function checkLogin()
    {
        $nowIP = getIP();
        $userModel = new UserModel();
        //获取session
        if (!$this->userId = $userModel->getSession()) {
            //获取cookie
            $cookie = Yii::$app->request->cookies;
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

        $this->userInfo = $userModel->getOneByCondition($this->userId, ['uid' => $this->userId]);

        return true;
    }

    public function apiCheckLogin()
    {
        $userModel = new UserModel();
        if (!$this->userId = $userModel->getSession()) {
            $this->outputJson('not_login');
        }

        $this->userInfo = $userModel->getOneByCondition($this->userId, ['uid' => $this->userId]);
    }

    public function outputJson($errorCode, $data = '', $msg = '')
    {
        $result = Config::errorLang($this->errorCodeFile, $errorCode);

        if (empty($result)) {
            $result = Config::errorLang($this->errorCodeFile, 'failed');
        }

        if (!empty($msg)) {
            $result['msg'] = $msg;
        }

        if (!empty($data)) {
            $result['data'] = $data;
        }

        Response::json($result);
    }

    public function success($data = '')
    {
        $result = Config::errorLang($this->errorCodeFile, 'success');
        if (!empty($result)) {
            $result['data'] = $data;
        }

        Response::json($result);
    }
}