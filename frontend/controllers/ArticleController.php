<?php
/**
 * Message: 文章操作
 * User: jzc
 * Date: 2018/10/29
 * Time: 4:19 PM
 * Return:
 */

namespace frontend\controllers;

use common\models\ArticleModel;
use common\models\ArticleIndexModel;
use common\models\UserModel;
use common\models\TagModel;
use common\lib\Request;
use Yii;
use yii\data\Pagination;

class ArticleController extends CommonController
{
    public $layout = 'index';
    public $enableCsrfValidation = false;

    public function actions()
    {
        return [
            'index' => [
                'class' => 'frontend\actions\Article\IndexAction'
            ],
            'hottest' => [
                'class' => 'frontend\actions\Article\HottestAction'
            ],
            'create' => [
                'class' => 'frontend\actions\Article\CreateAction'
            ],
        ];
    }

    public function actionCreateShow()
    {
        return $this->render('create');
    }


    //文章列表页
    public function actionList()
    {
        $condition = array();
        $params = Yii::$app->request->post();

        //标签
        if (!empty($params['tag'])) {
            $condition[] = ['tag' => $params['tag']];
        }

        //搜索 - 标题 或 内容
        if (!empty($params['search'])) {
            $condition[] = ['search' => $params['search']];
        }

        $articleModel = new ArticleModel();
        $count = $articleModel->getCountByCondition($condition);
        $page = new Pagination(['totalCount' => $count,'pageSize' => '10']);
        $articleList = array();//文章列表
        if ($count > 0) {
            $articleList = $articleModel->getListByCondition($condition, $page->limit, $page->offset);
            foreach ($articleList as $k => $v) {
                $articleList[$k]['redis_read_number'] = $articleModel->getArticleReadNumber($v['id']);
            }
        }

        $tagMap = (new TagModel())->getTagInfo(['status' => TagModel::TAG_STATUS_USING]);

        $data = [
            'article_list' => $articleList,
            'tag_map' => $tagMap,
            'pages' => $page
        ];

        return $this->render('list', $data);
    }

    //文章 - 时间线 - 列表
    public function actionTimeLine()
    {
        $maxID = (new Request())->get('max_id');//当前页的索引ID,由此计算上一页和下一页
        list($articleList, $newMaxID, $oldMaxID) = (new ArticleIndexModel())->getArticleByTime($maxID);

        $userInfo = array();
        //获取缓存数据
        if (!empty($articleList)) {
            $uid = array();
            foreach ($articleList as $k => $v) {
                $articleList[$k]['redis_read_number'] = (new ArticleModel())->getArticleReadNumber($v['id']);
                $uid[] = $v['uid'];
            }

            $userInfo = (new UserModel())->getUserMap($uid);
        }

        $tagList = (new TagModel())->getListByCondition(['status' => TagModel::TAG_STATUS_USING]);
        $tagMap = array();
        foreach ($tagList as $_tag) {
            $tagMap[$_tag['type']] = $_tag;
        }


        $data = [
            'article_list' => $articleList,
            'tag_map' => $tagMap,
            'user_info' => $userInfo,
            'new_max_id' => $newMaxID,
            'old_max_id' => $oldMaxID
        ];

        return $this->render('newest', $data);
    }
}