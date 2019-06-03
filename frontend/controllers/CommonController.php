<?php
/**
 * Message: 通用规则
 * User: jzc
 * Date: 2018/9/6
 * Time: 下午11:17
 * Return:
 */

namespace frontend\controllers;

use common\models\System\CookieModel;
use common\models\System\SessionModel;
use yii\web\Controller;
use Yii;
use common\models\UserModel;
use common\lib\Config;
use common\lib\Response;

class CommonController extends Controller
{
    public $userId;
    public $userInfo;

    public $requireLogin = false;
    public $errorCodeFile = 'frontErrorCode';


    public function beforeAction($action)
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

        return parent::beforeAction($action);
    }

    public function checkLogin()
    {
        $userModel = new UserModel();
        $sessionModel = new SessionModel();
        $cookieModel = new CookieModel();
        $nowIP = getIP();

        $uid = $sessionModel->getUidSession();
        if (empty($uid)) {//session为空
            $userCookie = $cookieModel->getUserInfoCookie();

            if (empty($userCookie)) {//cookie不存在
                Yii::$app->session->setFlash('failed', '登录后再访问');
                return Yii::$app->response->redirect(['login/index']);
            }

            //通过cookie自动登录
            $uid = $userModel->login($userCookie['uid'], $userCookie['password']);
            if (!$uid) {
                Yii::warning("try to login by cookie failed!login_ip:{$nowIP}", CATEGORIES_WARN);
                Yii::$app->session->setFlash('failed', '登录后再访问');
                return Yii::$app->response->redirect(['login/index']);
            }
        }

        $this->userId = $uid;
        $this->userInfo = $userModel->getUserInfo($uid);
        return $uid;
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