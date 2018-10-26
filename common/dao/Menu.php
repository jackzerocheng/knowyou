<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/10/25
 * Time: 3:40 PM
 * Return:
 */

namespace common\dao;

use yii\db\ActiveRecord;

class Menu extends ActiveRecord
{
    public static function tableName()
    {
        return "{{%menu}}";
    }

    /**
     * 按条件获取菜单列表
     * @param $condition
     * @return mixed
     */
    public function getListByCondition($condition = null)
    {
        $db = self::find();
        $db = self::handlerCondition($db, $condition);

        return $db->asArray()->all();
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