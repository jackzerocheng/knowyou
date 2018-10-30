<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/10/30
 * Time: 5:32 PM
 * Return:
 */

namespace common\dao;

use yii\db\ActiveRecord;

class Tag extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%tag}}';
    }

    public function getOneByCondition($condition)
    {
        $db = self::find();
        $db = self::handlerCondition($db, $condition);

        return $db->asArray()->one();
    }

    public function getListByCondition($condition, $orderBy = 'created_at desc')
    {
        $db = self::find();
        $db = self::handlerCondition($db, $condition);

        return $db->orderBy($orderBy)->asArray()->all();
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