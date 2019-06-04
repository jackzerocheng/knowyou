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

    const REDIS_COMMENT_NUMBER = 'comment_number:';//单个文章评论数
    const REDIS_COMMENT_REPLY_LIST = 'comment_reply_list:';//文章回复队列
    const REDIS_BASE_COMMENT_ID = 'base_comment_id';//评论基础值

    /** 文章评论数 */
    public function getCommentNumber($id)
    {
        return intval($this->get(self::REDIS_COMMENT_NUMBER . $id));
    }

    public function setCommentNumber($id, $value)
    {
        $rs = $this->set(self::REDIS_COMMENT_NUMBER . $id, $value, ONE_MONTH);
        return $rs;
    }

    public function incrCommentNumber($id)
    {
        $rs = $this->cache->incr(self::REDIS_COMMENT_NUMBER . $id);
        $this->cache->expire(self::REDIS_COMMENT_NUMBER . $id, ONE_MONTH);
        return $rs;
    }

    /** 文章回复列表 */
    public function pushCommentReplyList($value)
    {
        return $this->cache->lpush(self::REDIS_COMMENT_REPLY_LIST, $value);
    }

    public function brpopCommentReplyList()
    {
        $rs = [];
        $data = $this->cache->brpop(self::REDIS_COMMENT_REPLY_LIST, ONE_MINUTE);
        if (!empty($data)) {
            $rs = json_decode($data, true);
        }

        return $rs;
    }

    /** 评论基础ID */
    public function getCommentId($uid)
    {
        $baseId = intval($this->cache->incr(self::REDIS_BASE_COMMENT_ID));
        $commentId = $baseId * TABLE_PARTITION + intval($uid) % TABLE_PARTITION;

        return $commentId;
    }

    public function setCommentId($value)
    {
        return $this->set(self::REDIS_BASE_COMMENT_ID, $value);
    }
}