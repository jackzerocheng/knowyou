<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/10/23
 * Time: 3:00 PM
 * Return:
 */

namespace api\controllers;

use yii\web\Controller;
use common\lib\Config;
use common\lib\Response;

class CommonController extends Controller
{
    public $requireLogin = true;
    public $errorCodeFile = 'apiErrorCode';

    public $enableCsrfValidation = false;

    public function init()
    {
        parent::init();

        if ($this->requireLogin) {

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