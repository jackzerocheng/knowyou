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
        parent::init();

        if ($this->requireLogin) {

        }

        if ($this->requireAccessToken) {
            $this->WxAccessToken = Yii::$app->session->get(GetAccessToken::WX_ACCESS_TOKEN_KEY);

            if (!$this->WxAccessToken) {//没session则再次请求
                $data = (new GetAccessToken())->getAccessToken(WX_APP_ID, WX_APP_SECRET);
                $this->WxAccessToken = $data['access_token'];
                Yii::$app->session->set(GetAccessToken::WX_ACCESS_TOKEN_KEY, $data['access_token']);
                Yii::$app->session->setTimeout($data['expires_in']);
            }

            if (!$this->WxAccessToken) {
                $this->outputJson('failed');
            }
        }
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