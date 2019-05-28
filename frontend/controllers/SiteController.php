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
        $articleModel = new ArticleModel();
        $articleList = $articleModel->getArticleUpdateSet();//获取首页文章列表 - 策略：最新活跃文章

        //获取缓存数据
        if (!empty($articleList)) {
            foreach ($articleList as $k => $v) {
                $articleList[$k]['redis_read_number'] = $articleModel->getReadNumber($v['id'], false);
                $articleList[$k]['comment_number'] = Yii::$app->cache->get(CommentModel::CACHE_COMMENT_NUMBER.$v['id']) ? : 0;
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
        $tagList = (new TagModel())->getListByCondition(['status' => TagModel::TAG_STATUS_USING]);
        $tagMap = array();
        foreach ($tagList as $_tag) {
            $tagMap[$_tag['type']] = $_tag;
        }

        $data = [
            'article_list' => $articleList,
            'banner_index_image' => $bannerIndexImage,
            'tag_map' => $tagMap
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
