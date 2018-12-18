<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/10/20
 * Time: 4:03 PM
 * Return:
 */

namespace common\dao;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use Yii;

class UserAdmin extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%user_admin}}';
    }

    /**
     * @param array $condition
     * @return array
     */
    public function getOneByCondition($condition)
    {
        $db = self::find();
        $db = $this->handleCondition($db, $condition);
        return $db->asArray()->one();
    }

    /**
     * @param ActiveQuery $db
     * @param $condition
     * @return ActiveQuery
     */
    public function handleCondition($db, $condition)
    {
        if (!empty($condition) && is_array($condition)) {
            foreach ($condition as $k => $v) {
                $db = $db->andWhere([$k => $v]);
            }
        }

        return $db;
    }
}