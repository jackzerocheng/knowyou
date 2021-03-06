<?php
/**
 * Message: 文章操作
 * User: jzc
 * Date: 2019/1/4
 * Time: 4:49 PM
 * Return:
 */

namespace backend\controllers;

use common\models\ArticleIndexModel;
use common\models\ArticleModel;
use common\models\TagModel;
use common\models\UserModel;
use yii\data\Pagination;

class ArticleController extends CommonController
{
    //待审核列表页 -- 分页
    public function actionIndex()
    {
        $articleIndexModel = new ArticleIndexModel();
        $articleModel = new ArticleModel();

        $condition = ['status' => $articleModel::ARTICLE_STATUS_UNVERIFIED];
        //记录总数
        $count = $articleModel->getCountByCondition($condition);
        $page = new Pagination(['totalCount' => $count, 'pageSize' => '10']);
        $articleList = $articleIndexModel->getListByCondition($condition, $page->limit, $page->offset);
        $uid = array();
        //获取缓存数据
        foreach ($articleList as $k => $v) {
            $articleList[$k]['redis_read_number'] = $articleModel->getArticleReadNumber($v['id']);
            $uid[] = $v['uid'];
        }

        $tagList = (new TagModel())->getListByCondition(['status' => TagModel::TAG_STATUS_USING]);
        $tagMap = array();
        foreach ($tagList as $_tag) {
            $tagMap[$_tag['type']] = $_tag;
        }

        $userInfo = (new UserModel())->getUserMap($uid);
        $data = [
            'article_list' => $articleList,
            'tag_map' => $tagMap,
            'user_info' => $userInfo,
            'pages' => $page,
            'article_status_map' => $articleModel->articleStatusMap
        ];

        return $this->render('list', $data);
    }

    //文章审核
    public function actionVerify()
    {

    }
}