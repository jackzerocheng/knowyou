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

class CommentRedis extends BaseCache
{
    protected $useRedis = true;

    const REDIS_COMMENT_NUMBER = 'comment_number:';

    public function getCommentNumber($id)
    {
        return intval($this->get(self::REDIS_COMMENT_NUMBER . $id));
    }

    public function setCommentNumber($id, $value)
    {
        $rs = $this->set(self::REDIS_COMMENT_NUMBER . $id, $value);
        $this->cache->expire(self::REDIS_COMMENT_NUMBER . $id, ONE_MONTH);
        return $rs;
    }

    public function incrCommentNumber($id)
    {
        $rs = $this->cache->incr(self::REDIS_COMMENT_NUMBER . $id);
        $this->cache->expire(self::REDIS_COMMENT_NUMBER . $id, ONE_MONTH);
        return $rs;
    }
}