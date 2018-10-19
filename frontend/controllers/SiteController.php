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
use common\models\Banner;

class SiteController extends CommonController
{
    public $layout = 'index';

    public function actionIndex()
    {
        echo $this->userId;
        $articleModel = new Article($this->userId);
        $articleList = $articleModel->getListByCondition([]);

        $bannerModel = new Banner();
        $bannerWordCondition = [
            'platform_id' => $bannerModel::PLATFORM_WEB,
            'status' => $bannerModel::STATUS_SHOWING,
            'type' => $bannerModel::TYPE_INDEX_WORD_MESSAGE,
        ];
        $bannerWordList = $bannerModel->getListByCondition($bannerWordCondition);

        return $this->render('index', ['article_list' => $articleList, 'banner_word_list' => $bannerWordList]);
    }

    public function actionLogout()
    {
        $loginForm = new LoginForm();
        $loginForm->logout();
        return $this->redirect(['login/index']);
    }
}
