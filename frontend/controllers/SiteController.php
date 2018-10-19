<?php
/**
 * Message: 网站主页
 * User: jzc
 * Date: 2018/9/6
 * Time: 下午11:17
 * Return:
 */

namespace frontend\controllers;

use common\models\LoginForm;
use common\models\Article;

class SiteController extends CommonController
{
    public $layout = 'index';

    public function actionIndex()
    {
        echo $this->userId;
        $article = new Article($this->userId);
        $articleList = $article->getListByCondition([]);

        return $this->render('index', ['article_list' => $articleList]);
    }

    public function actionLogout()
    {
        $loginForm = new LoginForm();
        $loginForm->logout();
        return $this->redirect(['login/index']);
    }
}
