<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/10/29
 * Time: 4:19 PM
 * Return:
 */

namespace frontend\controllers;

use common\models\ArticleModel;
use common\models\CommentModel;
use common\models\UserModel;
use common\models\TagModel;
use common\lib\Request;
use Yii;
use yii\data\Pagination;

class ArticleController extends CommonController
{
    public $layout = 'index';

    public function actionIndex()
    {
        $articleModel = new ArticleModel();
        $id = (new Request())->get('id');
        if (empty($id)) {
            Yii::$app->session->setFlash('message', '对不起，你访问的页面不存在哦');
            return $this->redirect(['site/index']);
        }

        $articleInfo = $articleModel->getOneByCondition($id, ['id' => $id]);
        if (empty($articleInfo)) {
            Yii::$app->session->setFlash('message', '主人，我没找到你想要的！');
            return $this->redirect(['site/index']);
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

    public function actionList()
    {
        $articleModel = new ArticleModel();
        $count = $articleModel->getCountByCondition();
        $page = new Pagination(['totalCount' => $count,'pageSize' => '1']);
        $articleList = $articleModel->getListByCondition(null, $page->limit, $page->offset);

        $tagList = (new TagModel())->getListByCondition(['status' => TagModel::TAG_STATUS_USING]);
        $tagMap = array();
        foreach ($tagList as $_tag) {
            $tagMap[$_tag['type']] = $_tag;
        }

        $userInfo = (new UserModel())->getOneByCondition($this->userId);
        $data = [
            'article_list' => $articleList,
            'tag_map' => $tagMap,
            'user_info' => $userInfo,
            'pages' => $page
        ];

        return $this->render('list', $data);
    }

    public function actionSearch()
    {

    }
}