<?php
/**
 * Message: 评论cache
 * User: jzc
 * Date: 2019/6/3
 * Time: 1:41 PM
 * Return:
 */

namespace common\cache\Comment;

use common\cache\BaseCache;

class CommentCache extends BaseCache
{
    const CACHE_COMMENT_LIST = 'comment_list:';

    public function getCommentList($id)
    {
        $rs = array();

        $data = $this->get(self::CACHE_COMMENT_LIST . $id);
        if (!empty($data)) {
            $rs = json_decode($data, true);
        }

        return $rs;
    }

    public function setCommentList($id, $value)
    {
        return $this->set(self::CACHE_COMMENT_LIST . $id, $value, ONE_MONTH);
    }
}