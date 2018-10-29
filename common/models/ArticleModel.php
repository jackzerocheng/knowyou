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

    const REDIS_ARTICLE_READ_NUMBER = 'know_you_article_read_';//文章阅读数

    public function rules()
    {
        return parent::rules(); // TODO: Change the autogenerated stub
    }

    /**
     * 增加阅读数
     * @param $id
     * @return mixed
     */
    public function addReadNumber($id)
    {
        $readNumber = Yii::$app->redis->incr(self::REDIS_ARTICLE_READ_NUMBER . $id);
        return $readNumber;
    }

    /**
     * 获取or初始化阅读数
     * @param $id
     * @return int
     */
    public function getReadNumber($id)
    {
        $redis = Yii::$app->redis;
        $key = self::REDIS_ARTICLE_READ_NUMBER . $id;
        if (!$redis->exist($key)) {
            $redis->set($key, 1);
            return 1;
        }

        $readNumber = $redis->get($key);
        return $readNumber;
    }

    /**
     * 从所有表中获取文章记录
     * 当记录分布不均匀需要调整记录数
     * @param null $condition
     * @param int $limit
     * @param $offset
     * @return array
     */
    public function getListByCondition($condition = null, $limit = 100, $offset = 0)
    {
        $count = Article::TABLE_PARTITION;
        $realLimit = intval($limit / Article::TABLE_PARTITION);
        $result = array();

        while ($count - Article::TABLE_PARTITION < Article::TABLE_PARTITION) {
            $article = new Article($count);

            $result = array_merge($result, $article->getListByCondition($condition, $realLimit));
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