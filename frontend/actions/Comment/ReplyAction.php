<?php
/**
 * Message: 回复评论
 * User: jzc
 * Date: 2019/6/3
 * Time: 10:29 PM
 * Return:
 */

namespace frontend\actions\Comment;

use Yii;
use frontend\actions\BaseAction;
use common\models\CommentModel;

class ReplyAction extends BaseAction
{
    public function run()
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
        $rs = (new CommentModel())->replyComment($data);

        if ($rs) {
            $this->success();
        }

        $this->outputJson('failed');
    }
}