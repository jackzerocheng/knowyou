<?php
/**
 * Message: 网站主页
 * User: jzc
 * Date: 2018/9/6
 * Time: 下午11:17
 * Return:
 */

namespace frontend\controllers;

use common\models\UserModel;
use common\models\ArticleModel;
use Yii;

class SiteController extends CommonController
{
    public $layout = 'index';

    public function actionIndex()
    {
        $articleModel = new ArticleModel();
        $articleList = $articleModel->getListByCondition();

        return $this->render('index', ['article_list' => $articleList]);
    }

    public function actionLogout()
    {
        Yii::info("user logout;uid:{$this->userId}", CATEGORIES_INFO);
        (new UserModel())->logout();
        return $this->redirect(['login/index']);
    }
}
