<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/10/19
 * Time: 下午6:33
 * Return:
 */

namespace common\dao;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use Yii;

class Banner extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%banner}}';
    }

    public function getCountByCondition($condition)
    {
        $db = self::find();
        $db = $this->handlerCondition($db, $condition);

        return intval($db->count());
    }

    public function getOneByCondition($condition)
    {
        $db = self::find();
        $db = $this->handlerCondition($db, $condition);

        return $db->asArray()->one();
    }

    public function getListByCondition($condition, $limit = 1000, $offset = 0, $orderBy = 'created_at desc')
    {
        $db = self::find();
        $db = $this->handlerCondition($db, $condition);

        $rs = $db->offset($offset)->limit($limit)->orderBy($orderBy)->asArray()->all();
        return $rs;
    }

    public function insertData($data)
    {
        $data['created_at'] = empty($data['created_at']) ? NOW_DATE : $data['created_at'];

        $rs = Yii::$app->db->createCommand()->insert(static::tableName(), $data)->execute();
        return $rs;
    }

    public function updateData(array $data, $condition)
    {
        $data['updated_at'] = empty($data['updated_at']) ? NOW_DATE : $data['updated_at'];

        $rs = Yii::$app->db->createCommand()->update(self::tableName(), $data, $condition)->execute();
        return $rs;
    }

    /**
     * @param ActiveQuery $db
     * @param $condition
     * @return ActiveQuery
     */
    public function handlerCondition($db, $condition)
    {
        if (!empty($condition) && is_array($condition)) {
            foreach ($condition as $k => $v) {
                if ($k == 'valid_date') {
                    $db = $db->andWhere("start_at<='{$v}'");
                    $db = $db->andWhere("end_at>='{$v}'");
                } elseif ($k == 'not_status') {
                    $db = $db->andWhere("status != {$v}");
                } else {
                    $db = $db->andWhere([$k => $v]);
                }
            }
        }

        return $db;
    }
}