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

    public function actions()
    {
        return [
            'reply' => [
                'class' => 'frontend\actions\Comment\ReplyAction'
            ]
        ];
    }

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
}