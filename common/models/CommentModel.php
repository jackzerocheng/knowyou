<?php
/**
 * Message: 评论表
 * User: jzc
 * Date: 2018/10/30
 * Time: 5:57 PM
 * Return:
 */

namespace common\models;

use yii\base\Model;
use common\dao\Comment;
use Yii;

class CommentModel extends Model
{
    //评论状态
    const COMMENT_STATUS_NORMAL = 1;
    const COMMENT_STATUS_FORBIDDEN = 2;
    const COMMENT_STATUS_DELETED = 3;

    //Redis自增评论ID
    const BASE_ARTICLE_ID = 'BASE_COMMENT_ID';//id = base_id * partition + uid % partition
    //评论缓存key
    const HASH_COMMENT_LIST_KEY = 'WEB_COMMENT_LIST';

    /**
     * 获取评论数
     * @param $id
     * @param $condition
     * @return int
     */
    public function getCountByCondition($id, $condition)
    {
        return (new Comment($id))->getCountByCondition($condition);
    }

    /**
     * 分页获取评论列表
     * 第一次请求去读库，一次性取出所有评论并组织好结构
     * 然后将该结构缓存
     * @param $id
     * @param $condition
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    public function getListByCondition($id, $condition, $limit = 10, $offset = 0)
    {
        $redis = Yii::$app->redis;
        if ($redis->exists(self::HASH_COMMENT_LIST_KEY)) {
            $list = $redis->hget(self::HASH_COMMENT_LIST_KEY, $id);
            if (!empty($list)) {
                return $list;
            }
        }

        $data = (new Comment($id))->getAllList($condition);



        return $data;
    }
}