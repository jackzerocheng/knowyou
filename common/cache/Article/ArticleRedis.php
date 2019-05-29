<?php
/**
 * Message: 文章redis
 * User: jzc
 * Date: 2019/5/28
 * Time: 9:44 PM
 * Return:
 */

namespace common\cache\Article;

use common\cache\BaseCache;

class ArticleRedis extends BaseCache
{
    protected $useRedis = true;

    const REDIS_ACTIVE_ARTICLE_SET = 'active_article_id:';//活跃文章ID
    const REDIS_ARTICLE_READ_NUMBER = 'article_read_number:';//文章阅读数
    const REDIS_ARTICLE_TOTAL = 'article_total:';//文章总数统计

    /**
     * @param int $start - 排名，越小越新
     * @param int $number - 所需ID数
     * @return array
     */
    public function getActiveArticleID($start = 0, $number = 20)
    {
        $ids = $this->cache->zrange(self::REDIS_ACTIVE_ARTICLE_SET, $start, $number - 1);

        return !empty($ids) ? $ids : [];
    }

    /**
     * 500 -> 执行删除条件
     * 100,1000  -> 删除的排名区间
     * @param $id
     * @param $time - 时间戳
     * @return mixed
     */
    public function setActiveArticleID($id, $time)
    {
        $rs = $this->cache->zadd(self::REDIS_ACTIVE_ARTICLE_SET, $time, $id);

        //所需的只有前100条
        $number = $this->cache->zcard(self::REDIS_ACTIVE_ARTICLE_SET);
        if ($number > 500) {
            $this->cache->zremrangebyrank(self::REDIS_ACTIVE_ARTICLE_SET, 100, 1000);
        }

        return $rs;
    }

    public function getArticleReadNumber($id)
    {
        return intval($this->get(self::REDIS_ARTICLE_READ_NUMBER . $id));
    }

    public function setArticleReadNumber($id, $value)
    {
        $rs = $this->set(self::REDIS_ARTICLE_READ_NUMBER . $id, $value);
        $this->cache->expire(self::REDIS_ARTICLE_READ_NUMBER . $id, ONE_MONTH);
        return $rs;
    }

    public function incrArticleReadNumber($id)
    {
        $rs = $this->cache->incr(self::REDIS_ARTICLE_READ_NUMBER . $id);
        $this->cache->expire(self::REDIS_ARTICLE_READ_NUMBER . $id, ONE_MONTH);
        return $rs;
    }

    public function getArticleTotal()
    {
        return intval($this->get(self::REDIS_ARTICLE_TOTAL));
    }

    public function setArticleTotal($value)
    {
        $rs = $this->set(self::REDIS_ARTICLE_TOTAL, $value);
        $this->cache->expire(self::REDIS_ARTICLE_TOTAL, ONE_MONTH);
        return $rs;
    }

    public function incrArticleTotal()
    {
        $rs = $this->cache->incr(self::REDIS_ARTICLE_TOTAL);
        $this->cache->expire(self::REDIS_ARTICLE_TOTAL, ONE_MONTH);
        return $rs;
    }
}