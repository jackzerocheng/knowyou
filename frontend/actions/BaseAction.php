<?php
/**
 * Message: 基础action
 * User: jzc
 * Date: 2019/6/3
 * Time: 10:29 PM
 * Return:
 */

namespace frontend\actions;

use yii\base\Action;
use common\lib\Config;
use common\lib\Response;
use common\models\UserModel;
use common\models\System\SessionModel;
use common\models\System\CookieModel;
use Yii;

class BaseAction extends Action
{
    protected $uid;
    protected $userInfo;

    private $errorCodeFile = 'frontErrorCode';
    protected $requireLogin = false;

    protected function beforeRun()
    {
        if ($this->requireLogin) {
            $this->checkLogin();
        }

        return parent::beforeRun();
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

        $this->uid = $uid;
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

    public function checkParams($params, $needKeys)
    {
        if (empty($params)) {
            return false;
        }

        //筛选输入
        foreach ($params as $k => $v) {
            if (!in_array($k, $needKeys) || empty($v)) {
                unset($params[$k]);
            }
        }

        if (!empty(array_diff($needKeys, array_keys($params)))) {//键值比对
            return false;
        }

        return true;
    }
}