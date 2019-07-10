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

    //活跃文章ID集合
    const REDIS_ACTIVE_ARTICLE_SET = 'active_article_id:';
    //文章阅读数
    const REDIS_ARTICLE_READ_NUMBER = 'article_read_number:';
    //文章总数统计
    const REDIS_ARTICLE_TOTAL = 'article_total:';
    //文章基础ID
    const REDIS_BASE_ARTICLE_ID = 'base_article_id:';
    //文章热度ID集合
    const REDIS_HOTTEST_ARTICLE_ZSET = 'hottest_article_zset';

    /**
     * @param int $start - 排名，越小越新
     * @param int $number - 所需ID数
     * @return array
     */
    public function getActiveArticleID($start = 0, $number = 20)
    {
        $ids = $this->cache->zrange(self::REDIS_ACTIVE_ARTICLE_SET, $start, $number - 1);

        return $ids ?? [];
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

        if (mt_rand(0, 1000) > 990) {//1/100概率，执行清除多余数据
            //所需的只有前100条
            $number = $this->cache->zcard(self::REDIS_ACTIVE_ARTICLE_SET);
            if ($number > 500) {
                $this->cache->zremrangebyrank(self::REDIS_ACTIVE_ARTICLE_SET, 100, 1000);
            }
        }

        return $rs;
    }

    /** 文章阅读数 */
    public function getArticleReadNumber($id)
    {
        return intval($this->get(self::REDIS_ARTICLE_READ_NUMBER . $id));
    }

    public function setArticleReadNumber($id, $value)
    {
        $rs = $this->set(self::REDIS_ARTICLE_READ_NUMBER . $id, $value, ONE_MONTH);
        return $rs;
    }

    public function incrArticleReadNumber($id)
    {
        $rs = $this->cache->incr(self::REDIS_ARTICLE_READ_NUMBER . $id);
        $this->cache->expire(self::REDIS_ARTICLE_READ_NUMBER . $id, ONE_MONTH);
        return $rs;
    }

    /** 文章总数统计 */
    public function getArticleTotal()
    {
        return intval($this->get(self::REDIS_ARTICLE_TOTAL));
    }

    public function setArticleTotal($value)
    {
        $rs = $this->set(self::REDIS_ARTICLE_TOTAL, $value, ONE_MONTH);
        return $rs;
    }

    public function incrArticleTotal()
    {
        $rs = $this->cache->incr(self::REDIS_ARTICLE_TOTAL);
        $this->cache->expire(self::REDIS_ARTICLE_TOTAL, ONE_MONTH);
        return $rs;
    }

    /** 文章基础ID */
    public function getArticleId($uid)
    {
        $baseId = $this->cache->incr(self::REDIS_BASE_ARTICLE_ID);
        $articleId = $baseId * TABLE_PARTITION + intval($uid) % TABLE_PARTITION;

        return $articleId;
    }

    public function setArticleId($value)
    {
        $baseId = ($value - $value % 4) / 4;
        return $this->set(self::REDIS_BASE_ARTICLE_ID, $baseId);
    }

    /** 文章最热列表 */

    /**
     * @param $id
     * @param int $score  // 默认初始分数为10
     * @return mixed
     */
    public function setHottestArticle($id, $score = 10)
    {
        $rs = $this->cache->zadd(self::REDIS_HOTTEST_ARTICLE_ZSET, $score, $id);

        if (mt_rand(0, 1000) > 990) {//随机清除
            //集合长度校验
            $number = $this->cache->zcard(self::REDIS_HOTTEST_ARTICLE_ZSET);
            if ($number > 500) {
                $this->cache->zremrangebyrank(self::REDIS_HOTTEST_ARTICLE_ZSET, 100, 1000);
            }
        }

        return $rs;
    }

    /**
     * 获取列表
     * @param int $start
     * @param int $number
     * @return array
     */
    public function getHottestArticle($start = 0, $number = 20)
    {
        $ids = $this->cache->zrange(self::REDIS_HOTTEST_ARTICLE_ZSET, $start, $number - 1);

        return $ids ?? [];
    }

    /**
     * 有序集合增加分数
     * @param $id
     * @param int $increment
     * @return mixed
     */
    public function incrHottestScore($id, $increment = 1)
    {
        return $this->cache->zincrby(self::REDIS_HOTTEST_ARTICLE_ZSET, $increment, $id);
    }
}