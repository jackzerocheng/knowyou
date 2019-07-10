<?php
/**
 * Message: 文章详情页
 * User: jzc
 * Date: 2019/6/27
 * Time: 10:27 AM
 * Return:
 */

namespace frontend\actions\Article;

use frontend\actions\BaseAction;
use common\models\ArticleModel;
use common\models\CommentModel;
use common\lib\Request;
use Yii;
use common\models\UserModel;

class IndexAction extends BaseAction
{
    public function run()
    {
        $articleModel = new ArticleModel();
        $commentModel = new CommentModel();

        $id = (new Request())->get('id');
        if (empty($id)) {
            Yii::$app->session->setFlash('front_error_message', '对不起，你访问的页面不存在哦');
            return $this->controller->redirect(['site/error']);
        }

        $articleInfo = $articleModel->getArticleInfo($id);
        if (empty($articleInfo)) {
            Yii::$app->session->setFlash('front_error_message', '主人，我没找到你想要的！');
            return $this->controller->redirect(['site/error']);
        }

        //更新文章阅读数
        $readNumber = $articleModel->redis->incrArticleReadNumber($id);
        //更新文章热度
        $hotScore = $articleModel->incrHotScore($articleInfo);
        //更新文章活跃度
        $articleModel->redis->setActiveArticleID($id, time());


        $userInfo = (new UserModel())->getUserInfo($articleInfo['uid']);//作者信息获取
        $commentNumber = $commentModel->getCommentNumber($articleInfo['id']);//获取评论

        //TODO ajax异步加载评论列表
        $commentList = array();
        if ($commentNumber > 0) {
            $commentList = $commentModel->getCommentList($articleInfo['id'], ['status' => CommentModel::COMMENT_STATUS_NORMAL]);
        }

        $data = [
            'article_info' => $articleInfo,
            'read_number' => $readNumber,
            'user_info' => $userInfo,
            'comment_number' => $commentNumber,
            'comment_list' => $commentList,
        ];
        return $this->controller->render('article', $data);
    }
}