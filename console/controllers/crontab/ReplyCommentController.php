<?php
/**
 * Message: 回复评论 - 消息队列 - 每秒执行
 * User: jzc
 * Date: 2019/4/22
 * Time: 8:00 PM
 * Return:
 */

namespace console\controllers\crontab;

use common\models\ArticleModel;
use common\models\CommentModel;
use common\models\UserModel;
use Yii;

class ReplyCommentController extends BaseController
{
    public function actionIndex()
    {
        /*
         * crontab每分钟执行一次
         */

        //php.ini限制了脚本执行最长时间(默认为30s)，所以在脚本中手动修改时间
        set_time_limit(60);

        $redis = Yii::$app->redis;
        $articleModel = new ArticleModel();
        $userModel = new UserModel();
        $commentModel = new CommentModel();


        while (true) {
            //所有数据只负责传送，并未在之前做校验
            $jsonData = $redis->lpop($commentModel::LIST_COMMENT_REPLY);

            if (!empty($jsonData)) {
                $data = json_decode($jsonData, true);

                //文章ID校验
                if (empty($articleModel->getOneByCondition($data['article_id'], ['id' => $data['article_id']]))) {
                    Yii::warning("Not Exist Article;data:".$jsonData, CATEGORIES_WARN);
                    continue;
                }

                //用户ID校验
                if (empty($userModel->getOneByCondition($data['uid'], ['uid' => $data['uid']]))) {
                    Yii::warning("Not Exist User;data".$jsonData, CATEGORIES_WARN);
                    continue;
                }

                $rs = $commentModel->insert($data);
                if (!$rs) {
                    continue;
                }

                Yii::info("Reply Comment;data:".$jsonData, CATEGORIES_INFO);
            }

            sleep(1);//每秒执行一次
        }

        exit();
    }
}