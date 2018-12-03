<?php
/**
 * Message: 点赞记录dao
 * User: jzc
 * Date: 2018/12/3
 * Time: 1:39 PM
 * Return:
 */

namespace common\dao;

use yii\db\ActiveRecord;

class Praise extends ActiveRecord
{
    const TABLE_PARTITION = 4;
    protected static $tableName = '';

    public function __construct($articleID = 0, array $config = [])
    {
        parent::__construct($config);
        static::$tableName = "{{%praise0" . $articleID % self::TABLE_PARTITION . "}}";
    }

    public static function tableName()
    {
        return static::$tableName;
    }

    public function insert($runValidation = true, $data = null)
    {
        $data['created_at'] = empty($data['created_at']) ? NOW_DATE : $data['created_at'];

        if (!self::getDb()->schema->insert(static::tableName(), $data)) {
            return false;
        }

        return true;
    }

    public function getOneByCondition($condition)
    {
        $db = self::find()->from(self::$tableName);
        $db = $this->handlerCondition($db, $condition);

        $rs = $db->asArray()->one();
        return $rs;
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