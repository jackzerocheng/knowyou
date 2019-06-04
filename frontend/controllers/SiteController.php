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
use common\models\CommentModel;
use common\models\UserModel;
use common\models\ArticleModel;
use common\models\TagModel;
use Yii;

class SiteController extends CommonController
{
    public $layout = 'index';

    public function actionIndex()
    {
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods:* ');
        header('Access-Control-Allow-Headers:x-requested-with,content-type');

        $articleModel = new ArticleModel();
        //获取首页文章列表 - 策略：最新活跃文章
        $activeArticle = $articleModel->getActiveArticle();

        //获取缓存数据
        if (!empty($activeArticle)) {
            foreach ($activeArticle as $k => $v) {
                $activeArticle[$k]['redis_read_number'] = $articleModel->getArticleReadNumber($v['id']);
                $activeArticle[$k]['comment_number'] = (new CommentModel())->getCommentNumber($v['id']);
            }
        }

        $bannerModel = new BannerModel();
        $bannerCondition = [
            'platform_id' => $bannerModel::PLATFORM_WEB,
            'status' => $bannerModel::STATUS_SHOWING,
            'type' => $bannerModel::TYPE_INDEX_ROLL_IMAGE
        ];
        //首页滚屏图片
        $bannerIndexImage = $bannerModel->getListByCondition($bannerCondition);

        //标签获取
        $tagList = (new TagModel())->getTagInfo(['status' => TagModel::TAG_STATUS_USING]);

        $data = [
            'article_list' => $activeArticle,
            'banner_index_image' => $bannerIndexImage,
            'tag_map' => $tagList
        ];
        return $this->render('index', $data);
    }

    public function actionLogout()
    {
        Yii::info("user logout;uid:{$this->userId}", CATEGORIES_INFO);
        (new UserModel())->logout();
        return $this->redirect(['login/index']);
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }

        return $this->render('error');
    }
}
