<?php
/**
 * Message: 测试Controller
 * User: jzc
 * Date: 2018/10/25
 * Time: 5:44 PM
 * Return:
 */

namespace frontend\controllers;

use common\models\MenuModel;
use common\models\ArticleIndexModel;
use yii\web\Cookie;
use Yii;
use common\lib\CryptAes;
use common\lib\RandomString;
use common\models\WX\WxRulesModel;

class TestController extends CommonController
{
    public $requireLogin = false;

    public function actionIndex()
    {
        echo (new RandomString())->outputRandomString(16);

        $a = (new WxRulesModel())->getListByCondition([]);
        var_dump($a);
    }
}