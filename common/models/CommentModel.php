<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/10/30
 * Time: 5:57 PM
 * Return:
 */

namespace common\models;

use yii\base\Model;
use common\dao\Comment;

class CommentModel extends Model
{
    const COMMENT_STATUS_NORMAL = 1;
    const COMMENT_STATUS_FORBIDDEN = 2;
    const COMMENT_STATUS_DELETED = 3;

    public function getCountByCondition($id, $condition)
    {
        return (new Comment($id))->getCountByCondition($condition);
    }
}