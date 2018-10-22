<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/10/19
 * Time: 下午6:33
 * Return:
 */

namespace common\dao;

use yii\db\ActiveRecord;

class Banner extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%banner}}';
    }

    /**
     * 返回所有符合条件记录
     * @param $condition
     * @param $limit
     * @return array|ActiveRecord[]
     */
    public function getListByCondition($condition, $limit = 1000)
    {
        $db = self::find();
        $db = $this->handlerCondition($db, $condition);

        $rs = $db->limit($limit)->asArray()->all();
        return $rs;
    }

    public function handlerCondition($db, $condition)
    {
        if (!empty($condition) && is_array($condition)) {
            foreach ($condition as $k => $v) {
                if ($k == 'valid_date') {
                    $db = $db->andWhere("start_at<='{$v}'");
                    $db = $db->andWhere("end_at>='{$v}'");
                } else {
                    $db = $db->andWhere([$k => $v]);
                }
            }
        }

        return $db;
    }
}