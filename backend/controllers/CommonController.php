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

class CommonController extends Controller
{
    public $requireLogin = true;

    public function init()
    {
        parent::init();

        if ($this->requireLogin) {

        }
    }
}