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
    public static function tableName()
    {
        return '{{%comment}}';
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