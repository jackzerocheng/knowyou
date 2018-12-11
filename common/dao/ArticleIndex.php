<?php
/**
 * Message: 文章索引表
 * User: jzc
 * Date: 2018/12/7
 * Time: 10:26 AM
 * Return:
 */

namespace common\dao;

use yii\db\ActiveRecord;

class ArticleIndex extends ActiveRecord
{
    protected static $tableName = '';

    public function __construct($date = '', array $config = [])
    {
        parent::__construct($config);
        if (empty($date)) {
            $date = date('m');
        }
        static::$tableName = '{{%articleIndex' . $date . '}}';
    }

    public static function tableName()
    {
        return static::$tableName;
    }

    public function getListByCondition($condition, $limit = 1000, $offset = 0, $orderBy = 'created_at desc')
    {
        $db = self::find()->from(self::$tableName);
        $db = $this->handlerCondition($db, $condition);

        $rs = $db->offset($offset)->limit($limit)->orderBy($orderBy)->asArray()->all();
        return $rs;
    }

    public function getCountByCondition($condition)
    {
        $db = self::find()->from(self::$tableName);
        $db = $this->handlerCondition($db, $condition);

        return intval($db->count());
    }

    public function handlerCondition($db, $condition)
    {
        if (!empty($condition) && is_array($condition)) {
            foreach ($condition as $k => $v) {
                $db = $db->andWhere([$k => $v]);
            }
        }

        return $db;
    }
}