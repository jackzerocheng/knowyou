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
use common\models\ArticleIndexModel;
use yii\web\Cookie;
use Yii;
use common\lib\CryptAes;

class TestController extends CommonController
{
    public $requireLogin = false;

    public function actionIndex()
    {
        var_dump((new CryptAes(USER_AES_KEY))->encrypt('123456'));
    }
}