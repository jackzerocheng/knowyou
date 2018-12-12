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

class TestController extends CommonController
{
    public $requireLogin = false;

    public function actionIndex()
    {
        $data = (new ArticleIndexModel())->getArticleByTime(5, 10);
        var_dump($data);

        
    }
}