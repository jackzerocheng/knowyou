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

use common\dao\Article;
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
     * 无法做分页。最多只能获取上一页或下一页
     * 依照MAXID来定位
     * @param int $maxID
     * @param int $limit
     * @return mixed
     */
    public function getArticleByTime($maxID = 0, $limit = 10)
    {
        $articleCount = Yii::$app->redis->get(self::ARTICLE_NUMBER_COUNT) ? : 0;//获取计数
        if (!$maxID) {
            $maxID = $articleCount + 1;
        }

        if ($maxID > $articleCount) {
            $oldMaxID = -1;
        }

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

        //循环获取文章列表 -- 保证时间顺序 所以不用批量查询
        $articleList = array();
        $newMaxID = -1;
        if (!empty($data)) {
            foreach ($data as $_data) {
                $articleList[] = (new ArticleModel())->getOneByCondition($_data['article_id'], ['id' => $_data['article_id']]);
                $newMaxID = $_data['id'];
            }
        }

        //计算上一页
        if (!isset($oldMaxID)) {
            $oldMaxID = $maxID + $limit;
        }

        return array($articleList, $newMaxID, $oldMaxID);
    }

    /**
     * 批量查询获得文章列表
     * 时间倒序
     * 分页总数基于所有index表之和
     * @param null $condition
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getListByCondition($condition = null, $limit = 10, $offset = 0)
    {
        $tableNumber = $this->getTableNumberArray($condition);
        $total = 0;//所遍历的记录总数
        $pass = 0;//前面表的数据量
        foreach ($tableNumber as $k => $v) {
            $total += $v;

            if ($total > $offset) {
                $finalOffset = $offset - $pass;
                $finalKey = $k;
                if (($total < ($offset + $limit)) && $k > 0)  {//当前表数据不够当页列表
                    $lessNumber = $offset + $limit - $total;//不足的需要去下张表取
                }
                break;
            }

            $pass += $v;
        }

        if (!isset($finalOffset) || !isset($finalKey)) {
            Yii::warning("no article message available", CATEGORIES_WARN);
            return [];
        }

        $indexList = (new ArticleIndex($finalKey))->getListByCondition($condition, $limit, $finalOffset);
        if ($lessNumber) {
            $temp = (new ArticleIndex($finalKey -1))->getListByCondition($condition, $lessNumber, 0);
            $indexList = array_merge($indexList, $temp);
        }

        $articleList = array();
        if (!empty($indexList)) {
            foreach ($indexList as $index) {
                $articleList[] = (new ArticleModel())->getOneByCondition($index['article_id'], ['id' => $index['article_id']]);
            }
        }

        return $articleList;
    }

    /**
     * 获取所有文章总数
     * 循环获取
     * @param $condition
     * @return int
     */
    public function getArticleNumberCount($condition)
    {
        $tableNumber = $this->getTableNumberArray($condition);

        $total = 0;
        if (!empty($tableNumber)) {
            foreach ($tableNumber as $k => $v) {
                $total += $v;
            }
        }

        return $total;
    }

    /**
     * 获取索引表计数数组
     * 从后往前排列
     * @param $condition
     * @return array
     */
    public function getTableNumberArray($condition)
    {
        $nowCount = Yii::$app->redis->get(self::ARTICLE_NUMBER_COUNT);
        $key = intval($nowCount / self::MAX_RECORD_NUMBER);

        $rs = array();
        while ($key >= 0) {
            $rs[$key] = (new ArticleIndex($key))->getCountByCondition($condition);
            $key--;
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

        $id = $redis->incr(self::ARTICLE_NUMBER_COUNT);
        $key = intval($id / self::MAX_RECORD_NUMBER);
        $data = [
            'id' => $id,
            'article_id' => $articleID,
            'created_at' => NOW_DATE
        ];
        $rs = (new ArticleIndex($key))->insertData($data);

        if (!$rs) {
            Yii::error("insert data into article_index failed;article_id:{$articleID}", CATEGORIES_ERROR);
            return 0;
        }

        Yii::info("insert article index;id:{$id}", CATEGORIES_INFO);
        return $id;
    }
}