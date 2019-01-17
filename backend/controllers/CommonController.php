<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/10/20
 * Time: 9:41 AM
 * Return:
 */

namespace backend\controllers;

use yii\web\Controller;
use Yii;
use common\models\AdminModel;

class CommonController extends Controller
{
    protected $requireLogin = true;
    public $uid;
    public $level;//级别，权限控制
    public $status;

    public function init()
    {
        if ($this->requireLogin) {
            $this->requireLogin();
        }

        return true;
    }

    public function requireLogin()
    {
        if (!$this->uid = (new AdminModel())->getSession()) {
            Yii::$app->session->setFlash('error', '登录后再访问');
            return Yii::$app->response->redirect(['login/index']);
        }

        return true;
    }
}