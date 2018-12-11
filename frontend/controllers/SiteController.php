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
use common\models\TagModel;
use Yii;

class SiteController extends CommonController
{
    public $layout = 'index';

    public function actionIndex()
    {
        $articleModel = new ArticleModel();
        $articleList = $articleModel->getListByCondition(['status' => ArticleModel::ARTICLE_STATUS_NORMAL]);

        //获取缓存数据
        $uid = array();
        foreach ($articleList as $k => $v) {
            $articleList[$k]['redis_read_number'] = $articleModel->getReadNumber($v['id'], false);
            //去重
            if (!in_array($v['uid'], $uid)) {
                $uid[] = $v['uid'];
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

        //用户数据获取
        $userInfo = (new UserModel())->getUserMap($uid);
        $data = [
            'article_list' => $articleList,
            'banner_index_image' => $bannerIndexImage,
            'tag_map' => $tagMap,
            'user_info' => $userInfo
        ];
        return $this->render('index', $data);
    }

    public function actionLogout()
    {
        Yii::info("user logout;uid:{$this->userId}", CATEGORIES_INFO);
        (new UserModel())->logout();
        return $this->redirect(['login/index']);
    }
}
