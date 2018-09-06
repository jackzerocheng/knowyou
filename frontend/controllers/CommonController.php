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

class CommonController extends Controller
{
    public $userId;
    public $userName;

    public function init()
    {
        parent::init();

        //获取session
        if (!$this->getSession()) {
            //获取cookie
        }
    }

    private function getSession()
    {

    }
}