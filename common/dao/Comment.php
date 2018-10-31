<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/10/30
 * Time: 5:55 PM
 * Return:
 */

namespace common\dao;

use yii\db\ActiveRecord;

class Comment extends ActiveRecord
{
    const BASE_ARTICLE_ID = 'BASE_COMMENT_ID';//id = base_id * partition + uid % partition
    const TABLE_PARTITION = 4;
    protected static $tableName = '';

    public function __construct($id, array $config = [])
    {
        parent::__construct($config);
        static::$tableName = '{{%comment0' . $id % self::TABLE_PARTITION . '}}';
    }

    public static function tableName()
    {
        return static::$tableName;
    }

    public function getCountByCondition($condition)
    {
        $db = self::find();
        $db = self::handlerCondition($db, $condition);

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