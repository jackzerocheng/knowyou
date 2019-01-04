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
        $data['created_at'] = $data['created_at'] ? : NOW_DATE;
        $rs = Yii::$app->db->createCommand()->insert(static::tableName(), $data)->execute();
        return $rs;
    }

    public function updateInfo($data, $condition)
    {
        $data['updated_at'] = $data['updated_at'] ? : NOW_DATE;
        $rs = Yii::$app->db->createCommand()->update(static::tableName(), $data, $condition)->execute();
        return $rs;
    }

    /**
     * 禁用
     * @param $condition
     * @return int
     */
    public function deleteInfo($condition)
    {
        $rs = Yii::$app->db->createCommand()->delete(static::tableName(), $condition)->execute();
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
                if ($k == 'except_status') {
                    $db = $db->andWhere("status != {$v}");
                } else {
                    $db = $db->andWhere([$k => $v]);
                }
            }
        }

        return $db;
    }
}