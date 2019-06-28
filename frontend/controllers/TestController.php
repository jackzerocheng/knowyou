<?php
/**
 * Message: 测试Controller
 * User: jzc
 * Date: 2018/10/25
 * Time: 5:44 PM
 * Return:
 */

namespace frontend\controllers;

use common\cache\Article\ArticleRedis;
use common\cache\Comment\CommentRedis;
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

    public function actions()
    {
        return [
            'test' => [
                'class' => 'frontend\actions\Test\TestAction'
            ]
        ];
    }

    public function actionIndex()
    {
        var_dump(Yii::$app->request->post());
        $controller = Yii::$app->controller;
        echo $controller->module->id . $controller->id . $controller->action->id;
        echo "<br>\n";

        var_dump((new ArticleRedis())->incrArticleReadNumber(1));
        //$rs = Yii::$app->cache->get('WEB_COMMENT_LIST_17');
        //var_dump(time());
        //$test = Yii::$app->redis->zrange('test',0,10);
        //var_dump($test);
        //echo (new RandomString())->outputRandomString(16);

        //$a = (new WxRulesModel())->getListByCondition([]);
        //var_dump($a);
    }
}