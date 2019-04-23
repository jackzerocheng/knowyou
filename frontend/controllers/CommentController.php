<?php
/**
 * Message: 评论API
 * User: jzc
 * Date: 2019/4/19
 * Time: 3:48 PM
 * Return:
 */

namespace frontend\controllers;

use common\models\ArticleModel;
use common\models\CommentModel;
use Yii;

class CommentController extends CommonController
{
    public $enableCsrfValidation = false;
    public $apiCheckLogin = true;
    /*
     * 加载文章/帖子评论列表
     */
    public function actionIndex()
    {

    }

    /*
     * 删除评论
     */
    public function actionDelete()
    {

    }

    /*
     * 回复评论
     */
    public function actionReply()
    {
        $data = Yii::$app->request->post();

        //参数校验
        $needKeys = ['article_id', 'content', 'uid', 'parent_id'];
        $data = getNeedData($data, $needKeys);
        if (!empty(array_diff($needKeys, array_keys($data)))) {
            $this->outputJson('params_error');
        }

        $data['username'] = $this->userInfo['username'];
        $data['head'] = $this->userInfo['head'];
        $data['created_at'] = NOW_DATE;

        //写入消息队列来执行
        $redis = Yii::$app->redis;
        $rs = $redis->lpush(CommentModel::LIST_COMMENT_REPLY, json_encode($data));

        if ($rs) {
            $this->success();
        }

        $this->outputJson('failed');
    }
}