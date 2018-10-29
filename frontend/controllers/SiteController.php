<?php
/**
 * Message: 网站主页
 * User: jzc
 * Date: 2018/9/6
 * Time: 下午11:17
 * Return:
 */

namespace frontend\controllers;

use common\models\BannerModel;
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

        $bannerModel = new BannerModel();
        $bannerCondition = [
            'platform_id' => $bannerModel::PLATFORM_WEB,
            'status' => $bannerModel::STATUS_SHOWING,
            'type' => $bannerModel::TYPE_INDEX_ROLL_IMAGE
        ];
        //首页滚屏图片
        $bannerIndexImage = $bannerModel->getListByCondition($bannerCondition);

        return $this->render('index', ['article_list' => $articleList, 'banner_index_image' => $bannerIndexImage]);
    }

    public function actionLogout()
    {
        Yii::info("user logout;uid:{$this->userId}", CATEGORIES_INFO);
        (new UserModel())->logout();
        return $this->redirect(['login/index']);
    }
}
