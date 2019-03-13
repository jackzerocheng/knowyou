<?php
/**
 * Message: 留言表
 * User: jzc
 * Date: 2019/3/13
 * Time: 10:10 AM
 * Return:
 */

namespace common\dao;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use Yii;

class Suggest extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%suggest}}';
    }

    public function insertData($data)
    {
        $data['created_at'] = empty($data['created_at']) ? NOW_DATE : $data['created_at'];

        $rs = Yii::$app->db->createCommand()->insert(static::tableName(), $data)->execute();
        return $rs;
    }

    public function getOneByCondition($condition)
    {
        $db = self::find();
        $db = self::handlerCondition($db, $condition);
        return $db->asArray()->one();
    }

    public function getListByCondition($condition, $limit = 100, $offset = 0, $orderBy = 'created_at desc')
    {
        $db = self::find();
        $db = self::handlerCondition($db, $condition);

        return $db->offset($offset)->limit($limit)->orderBy($orderBy)->asArray()->all();
    }

    public function getCountByCondition($condition)
    {
        $db = self::find();
        $db = self::handlerCondition($db, $condition);

        return intval($db->count());
    }

    /**
     * @param ActiveQuery $db
     * @param $condition
     * @return mixed
     */
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