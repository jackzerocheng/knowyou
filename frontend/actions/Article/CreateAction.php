<?php
/**
 * Message: 发表文章
 * User: jzc
 * Date: 2019/7/9
 * Time: 4:13 PM
 * Return:
 */

namespace frontend\actions\Article;

use Yii;
use frontend\actions\BaseAction;
use common\models\ArticleModel;

class CreateAction extends BaseAction
{
    protected $requireLogin = true;

    public function run()
    {
        $articleModel = new ArticleModel();
        $data = Yii::$app->request->post();
        $needKeys = ['subject', 'content'];
        if (!$this->checkParams($data, $needKeys)) {
            $this->outputJson('params_error');
        }

        //封面图片处理
        if (empty($data['cover'])) {
            //系统选择默认图片
            if (preg_match("/src=\"(.+?)\"/", $data['content'], $match)) {
                $data['cover'] = $match[1];//文章内图片
            } else {
                $data['cover'] = ArticleModel::ARTICLE_COVER_DEFAULT;//默认图片
            }
        }

        $info = [
            'uid' => $this->uid,
            'username' => $this->userInfo['username'],
            'head' => $this->userInfo['head'],
            'title' => $data['subject'],
            'cover' => $data['cover'],
            'content' => $data['content'],
            'status' => $articleModel::ARTICLE_STATUS_NORMAL
            //tag
        ];

        //插入文章记录
        $articleID = $articleModel->insert($info);

        if (!$articleID) {
            $this->outputJson('create_article_failed');
        }

        //更新文章总数
        $articleModel->redis->incrArticleTotal();
        //更新活跃列表
        $articleModel->redis->setActiveArticleID($articleID, time());
        //更新热度列表
        $articleModel->redis->setHottestArticle($articleID);


        $this->success(['article_id' => $articleID]);
    }
}