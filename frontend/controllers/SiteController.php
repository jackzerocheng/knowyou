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
        echo $this->userId;
        $articleModel = new ArticleModel($this->userId);
        $articleList = $articleModel->getListByCondition([]);

        $bannerModel = new BannerModel();
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
        $loginForm = new UserModel();
        $loginForm->logout();
        return $this->redirect(['login/index']);
    }
}
