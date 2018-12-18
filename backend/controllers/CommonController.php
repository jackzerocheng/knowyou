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

class CommonController extends Controller
{
    protected $requireLogin = false;
    public $uid;

    public function init()
    {
        parent::init();

        if ($this->requireLogin) {
            if (!$this->uid) {
                return Yii::$app->response->redirect(['login/index']);
            }
        }

        return true;
    }
}