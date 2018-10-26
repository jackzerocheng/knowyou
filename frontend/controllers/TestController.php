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
        $arr = [
            0 => ['weight' => 1],
            1 => ['weight' => 2],
            2 => ['weight' => 3],
            3 => ['weight' => 4]
        ];

        var_dump(quickSortToArray($arr, 'weight'));
    }
}