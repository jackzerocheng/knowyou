<?php
/**
 * Message: 文章评论cache
 * User: jzc
 * Date: 2019/5/28
 * Time: 6:13 PM
 * Return:
 */

namespace common\cache\Comment;

use common\cache\BaseCache;

class CommentCache extends BaseCache
{
    const CACHE_COMMENT_NUMBER = 'comment_number:';

    public function getCommentNumber($id)
    {
        return intval($this->get(self::CACHE_COMMENT_NUMBER . $id));
    }

    public function incrCommentNumber($id)
    {
        $number = $this->getCommentNumber($id);

        $this->set(self::CACHE_COMMENT_NUMBER . $id, ++$number, ONE_MONTH);

        return $number;
    }
}