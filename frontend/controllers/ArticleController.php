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
use common\models\CommentModel;
use common\models\UserModel;
use common\models\TagModel;
use common\lib\Request;
use Yii;
use yii\data\Pagination;

class ArticleController extends CommonController
{
    public $layout = 'index';

    //文章详情页
    public function actionIndex()
    {
        $articleModel = new ArticleModel();
        $id = (new Request())->get('id');
        if (empty($id)) {
            Yii::$app->session->setFlash('front_error_message', '对不起，你访问的页面不存在哦');
            return $this->redirect(['site/error']);
        }

        $articleInfo = $articleModel->getOneByCondition($id, ['id' => $id]);
        if (empty($articleInfo)) {
            Yii::$app->session->setFlash('front_error_message', '主人，我没找到你想要的！');
            return $this->redirect(['site/error']);
        }
        $readNumber = $articleModel->getReadNumber($id);

        $userInfo = (new UserModel())->getOneByCondition($this->userId);
        $commentNumber = (new CommentModel())->getCountByCondition($articleInfo['id'], ['article_id' => $articleInfo['id'], 'status' => CommentModel::COMMENT_STATUS_NORMAL]);
        $data = [
            'article_info' => $articleInfo,
            'read_number' => $readNumber,
            'user_info' => $userInfo,
            'comment_number' => $commentNumber
        ];
        return $this->render('article', $data);
    }

    //文章列表页
    public function actionList()
    {
        $condition = array();
        //搜索
        if ($key = Yii::$app->request->post('search')) {
            $condition = ['search' => $key];
        }

        $articleModel = new ArticleModel();
        $count = $articleModel->getCountByCondition($condition);
        $page = new Pagination(['totalCount' => $count,'pageSize' => '10']);
        $articleList = $articleModel->getListByCondition($condition, $page->limit, $page->offset);
        $uid = array();
        //获取缓存数据
        foreach ($articleList as $k => $v) {
            $articleList[$k]['redis_read_number'] = $articleModel->getReadNumber($v['id'], false);
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
            'pages' => $page
        ];

        return $this->render('list', $data);
    }

    //文章发表页
    public function actionCreate()
    {
        $this->checkLogin();

        $data = array();
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();

            if (empty($data['cover'])) {
                //系统选择默认图片
                if (preg_match("/src=\"(.+?)\"/", $data['content'], $match)) {
                    $data['cover'] = $match[1];//文章内图片
                } else {
                    $data['cover'] = ArticleModel::ARTICLE_COVER_DEFAULT;//默认图片
                }
            }

            if (!$articleID = (new ArticleModel())->insert($data)) {
                Yii::$app->session->setFlash('message', '发表失败');
            } else {
                $this->redirect(['article/index', 'id' => $articleID]);
            }
        }

        return $this->render('create', ['data' => $data]);
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
                $articleList[$k]['redis_read_number'] = (new ArticleModel())->getReadNumber($v['id'], false);
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

    /*
     * 最热文章
     */
    public function actionHottest()
    {

    }
}