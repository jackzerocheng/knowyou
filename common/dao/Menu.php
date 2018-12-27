<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/10/25
 * Time: 3:40 PM
 * Return:
 */

namespace common\dao;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use Yii;

class Menu extends ActiveRecord
{
    public static function tableName()
    {
        return "{{%menu}}";
    }

    /**
     * @param $condition
     * @return array
     */
    public function getOneByCondition($condition)
    {
        $db = self::find();
        $db = self::handlerCondition($db, $condition);

        return $db->asArray()->one();
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

    public function insertInfo($data)
    {
        $rs = Yii::$app->db->createCommand()->insert(static::tableName(), $data)->execute();
        return $rs;
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
                $db = $db->andWhere([$k => $v]);
            }
        }

        return $db;
    }
}