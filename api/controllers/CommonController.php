<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/10/23
 * Time: 3:00 PM
 * Return:
 */

namespace api\controllers;

use common\lib\wx\GetAccessToken;
use yii\web\Controller;
use common\lib\Config;
use common\lib\Response;
use Yii;

class CommonController extends Controller
{
    public $requireLogin = false;
    public $requireAccessToken = false;
    public $errorCodeFile = 'apiErrorCode';

    public $enableCsrfValidation = false;
    public $WxAccessToken;

    public function init()
    {
        /*
         * 记录每次请求信息
         */
        $moduleName = Yii::$app->controller->module->id;
        $controllerName = Yii::$app->controller->id;
        $actionName = Yii::$app->controller->action->id;
        Yii::info("Request Route:".$moduleName.'/'.$controllerName.'/'.$actionName.';Client IP:'.getIP(), CATEGORIES_ACCESS);

        parent::init();

        if ($this->requireLogin) {//登录态token校验
            $this->checkLogin();
        }

        if ($this->requireAccessToken) {//微信access_token获取
            $this->WxAccessToken = Yii::$app->session->get(GetAccessToken::WX_ACCESS_TOKEN_KEY);

            if (!$this->WxAccessToken) {//没session则再次请求
                $data = (new GetAccessToken())->getAccessToken(WX_APP_ID, WX_APP_SECRET);
                if (!$data) {
                    $this->outputJson('get_access_token_failed');
                }

                $this->WxAccessToken = $data['access_token'];
                Yii::$app->session->set(GetAccessToken::WX_ACCESS_TOKEN_KEY, $data['access_token']);
                Yii::$app->session->setTimeout($data['expires_in']);
            }

        }
    }

    public function checkLogin()
    {

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