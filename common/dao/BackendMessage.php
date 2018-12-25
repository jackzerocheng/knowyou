<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/12/24
 * Time: 8:23 PM
 * Return:
 */

namespace common\dao;


use yii\db\ActiveRecord;

class BackendMessage extends ActiveRecord
{
    public static function tableName()
    {
        return "{{%backend_message}}";
    }

    public function getListByCondition($condition, $limit = 1000, $offset = 0, $orderBy = 'created_at desc')
    {
        $db = self::find();
        $db = $this->handlerCondition($db, $condition);

        $rs = $db->offset($offset)->limit($limit)->orderBy($orderBy)->asArray()->all();
        return $rs;
    }

    public function getCountByCondition($condition)
    {
        $db = self::find();
        $db = $this->handlerCondition($db, $condition);

        $rs = $db->count();
        return intval($rs);
    }

    public function handlerCondition($db, $condition)
    {
        if (!empty($condition) && is_array($condition)) {
            foreach ($condition as $k => $v) {
                if ($k == 'start_at') {
                    $db = $db->andWhere("created_at >= '{$v}'");
                } elseif ($k == 'end_at') {
                    $db = $db->andWhere("created_at < '{$v}'");
                } else {
                    $db = $db->andWhere([$k => $v]);
                }
            }
        }

        return $db;
    }
}