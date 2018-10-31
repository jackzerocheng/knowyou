<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/10/22
 * Time: 3:31 PM
 * Return:
 */

namespace common\models;

use yii\base\Model;
use common\dao\Article;
use Yii;

class ArticleModel extends Model
{
    const ARTICLE_STATUS_NORMAL = 1;//正常
    const ARTICLE_STATUS_FORBIDDEN = 2;//封禁，无法查看
    const ARTICLE_STATUS_UNCOMMENT = 3;//无法评论
    const ARTICLE_STATUS_DELETED = 4;//删除

    const REDIS_ARTICLE_READ_NUMBER = 'know_you_article_read_number_';//文章阅读数 hash 有效期三天
    const REDIS_EXPIRE_TIME = 259200;//三天

    public function rules()
    {
        return parent::rules(); // TODO: Change the autogenerated stub
    }

    /**
     * 获取or初始化阅读数
     * @param $id
     * @return int
     */
    public function getReadNumber($id)
    {
        $redis = Yii::$app->redis;
        $nowDate = date('Ymd');
        //新一日，切换新的缓存hash
        if (!$redis->exists(self::REDIS_ARTICLE_READ_NUMBER . $nowDate)) {
            $redis->hset(self::REDIS_ARTICLE_READ_NUMBER . $nowDate, 'base_id', 0);
            $redis->expire(self::REDIS_ARTICLE_READ_NUMBER . $nowDate, self::REDIS_EXPIRE_TIME);
            Yii::warning("msg:set redis read number hash;date:{$nowDate};", CATEGORIES_WARN);
        }

        //获取今日的缓存，若没有则去取昨日缓存（说明这个时间段没人访问这个ID）
        if (!$redis->hexists(self::REDIS_ARTICLE_READ_NUMBER . date('Ymd'), $id)) {
            $readNumber = $redis->hget(self::REDIS_ARTICLE_READ_NUMBER . date('Ymd', strtotime('yesterday')), $id);
            if (!$readNumber) {
                //缓存丢失，穿透DB
                $articleInfo = $this->getOneByCondition($id);
                $readNumber = $articleInfo['read_number'];
                Yii::warning("msg:get db read number;article_id:{$id};", CATEGORIES_WARN);
            }
            //重设缓存
            $redis->hset(self::REDIS_ARTICLE_READ_NUMBER . date('Ymd'), $id, $readNumber + 1);
        } else {
            $readNumber = $redis->hget(self::REDIS_ARTICLE_READ_NUMBER . date('Ymd'), $id);
            $redis->hset(self::REDIS_ARTICLE_READ_NUMBER . date('Ymd'), $id, $readNumber + 1);
        }

        return $readNumber + 1;
    }

    /**
     * 从所有表中获取文章记录
     * 需要当无指定条件时，每次返回数据不同
     * @param null $condition
     * @param int $limit //每个分表里取的数量
     * @param $offset
     * @return array
     */
    public function getListByCondition($condition = null, $limit = 10, $offset = 0)
    {
        $count = Article::TABLE_PARTITION;
        $result = array();

        while ($count - Article::TABLE_PARTITION < Article::TABLE_PARTITION) {
            $article = new Article($count);
            //无指定条件下，需要随机返回数据
            if (empty($condition) && $offset == 0) {
                $sum = $article->getCountByCondition(null);
                $page = is_int($sum / $limit) ? $sum / $limit : (intval($sum / $limit) + 1);
                $offset = mt_rand(0, $page);
            }

            $result = array_merge($result, $article->getListByCondition($condition, $limit, $offset));
            $count++;
        }

        return $result;
    }

    /**
     * 查询单条文章记录，注意ID可传入UID或者article_id
     * @param $id
     * @param null $condition
     * @return mixed
     */
    public function getOneByCondition($id, $condition = null)
    {
        $index = intval($id) % Article::TABLE_PARTITION;
        $article = new Article($index);
        return $article->getOneByCondition($condition);
    }

    /**
     * 插入文章并返回文章ID
     * @param array $data
     * @return bool
     */
    public function insert(array $data)
    {
        if (empty($data) || empty($data['uid'])) {
            return false;
        }

        $article = new Article($data['uid']);
        if (!$articleID = $article->insert(false, $data)) {
            return false;
        }

        return $articleID;
    }
}