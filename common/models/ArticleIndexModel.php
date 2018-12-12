<?php
/**
 * Message: 文章索引
 * 每张表十万条数据，满了后切下一张表
 * User: jzc
 * Date: 2018/12/10
 * Time: 10:39 PM
 * Return:
 */

namespace common\models;

use yii\base\Model;
use common\dao\ArticleIndex;
use Yii;

class ArticleIndexModel extends Model
{
    const ARTICLE_NUMBER_COUNT = 'ARTICLE_NUMBER_COUNT';//记录文章总数
    const MAX_RECORD_NUMBER = 10000000;//每张表最大存储数 -- 一千万

    /**
     * 按时间倒序获取文章！！！
     * 每次固定取N条
     * 依照MAXID来定位
     * @param int $maxID
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    public function getArticleByTime($maxID = 0, $limit = 10, $offset = 0)
    {
        $key = intval($maxID / self::MAX_RECORD_NUMBER);

        $count = (new ArticleIndex($key))->getCountByCondition(['max_id' => $maxID]);
        $needNumber = 0;
        if ($count < $limit && $maxID - $limit > 0 && ($maxID - $limit) < $key * self::MAX_RECORD_NUMBER) {
            //剩余数据不足，需要切换到下一张表取数据
            $needNumber = $limit - $count;
        }

        $data = (new ArticleIndex($key))->getAllList(['max_id' => $maxID], $limit);
        if ($needNumber > 0) {
            //去下一张表去数据
            $temp = (new ArticleIndex($key - 1))->getAllList(['max_id' => $maxID], $needNumber);
            $data = array_merge($data, $temp);
        }

        $sort = array();
        if (!empty($data)) {//将ARTICLE_ID分组
            foreach ($data as $_data) {
                $partition = $_data['article_id'] % ArticleModel::TABLE_PARTITION;
                $sort[$partition][] = $_data['article_id'];
            }
        }

        $rs = array();
        if (!empty($sort)) {//依次获取数据
            foreach ($sort as $k => $v) {
                $temp = (new ArticleModel())->getAllList($k, ['id' => $v]);
                $rs = array_merge($rs, $temp);
            }
        }

        return $rs;
    }

    /**
     * 插入一条文章索引，失败返回0
     * @param $articleID
     * @return int
     */
    public function insert($articleID)
    {
        $redis = Yii::$app->redis;
        if (!$redis->exists(self::ARTICLE_NUMBER_COUNT)) {
            $redis->set(self::ARTICLE_NUMBER_COUNT, 0);
        }

        $id = $redis->incr(self::ARTICLE_NUMBER_COUNT);
        $key = intval($id / self::MAX_RECORD_NUMBER);
        $data = [
            'id' => $id,
            'article_id' => $articleID,
            'created_at' => NOW_DATE
        ];
        $rs = (new ArticleIndex($key))->insertData($data);

        if (!$rs) {
            Yii::warning("insert data into article_idnex failed;article_id:{$articleID}", CATEGORIES_WARN);
            $redis->decr(self::ARTICLE_NUMBER_COUNT);//失败则减一  保证计数正确
            return 0;
        }

        Yii::info("insert article index;id:{$id}", CATEGORIES_INFO);
        return $id;
    }
}