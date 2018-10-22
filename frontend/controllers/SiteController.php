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
use common\models\BannerModel;

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
        $loginForm = new UserModel();
        $loginForm->logout();
        return $this->redirect(['login/index']);
    }
}
