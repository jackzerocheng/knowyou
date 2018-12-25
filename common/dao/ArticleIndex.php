<?php
/**
 * Message: 文章索引表
 * 水平分表，每张表一千万条数据
 * User: jzc
 * Date: 2018/12/7
 * Time: 10:26 AM
 * Return:
 */

namespace common\dao;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use Yii;

class ArticleIndex extends ActiveRecord
{
    protected static $tableName = '';

    public function __construct($key = 0, array $config = [])
    {
        parent::__construct($config);
        static::$tableName = '{{%article_index0' . $key . '}}';
    }

    public static function tableName()
    {
        return static::$tableName;
    }

    public function insertData($data)
    {
        $rs = Yii::$app->db->createCommand()->insert(static::$tableName, $data)->execute();
        return $rs;
    }

    public function getAllList($condition, $limit = 1000, $orderBy = 'created_at desc')
    {
        $db = self::find()->from(self::$tableName);
        $db = $this->handlerCondition($db, $condition);

        $rs = $db->limit($limit)->orderBy($orderBy)->asArray()->all();
        return $rs;
    }

    public function getMaxID()
    {
        $rs = Yii::$app->db->createCommand('select max(id) as max_id from knowyou_article_index00')->queryOne();
        return $rs['max_id'] ? intval($rs['max_id']) : 0;
    }

    public function getCountByCondition($condition)
    {
        $db = self::find()->from(self::$tableName);
        $db = $this->handlerCondition($db, $condition);

        return intval($db->count());
    }

    /**
     * @param $db ActiveQuery
     * @param $condition
     * @return ActiveQuery
     */
    public function handlerCondition($db, $condition)
    {
        if (!empty($condition) && is_array($condition)) {
            foreach ($condition as $k => $v) {
                if ($k == 'start_id') {
                    $db = $db->andWhere("id > {$v}");
                } elseif($k == 'max_id') {
                    $db = $db->andWhere("id < {$v}");
                } else {
                    $db = $db->andWhere([$k => $v]);
                }
            }
        }

        return $db;
    }
}