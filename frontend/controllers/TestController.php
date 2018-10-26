<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/10/25
 * Time: 5:44 PM
 * Return:
 */

namespace frontend\controllers;

use common\models\MenuModel;

class TestController extends CommonController
{
    public $requireLogin = false;

    public function actionIndex()
    {
        $menuList = (new MenuModel())->getMenuList();
        var_dump($menuList);
    }
}