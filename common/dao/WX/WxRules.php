<?php
/**
 * Message:
 * User: jzc
 * Date: 2019/1/29
 * Time: 5:59 PM
 * Return:
 */

namespace common\dao\WX;

use Yii;
use yii\db\ActiveRecord;

class WxRules extends ActiveRecord
{
    public static function tableName()
    {
        return '{{wx_rules}}';
    }

    public function insertData(array $data)
    {
        $data['created_at'] = $data['created_at'] ?: NOW_DATE;

        $rs = Yii::$app->db->createCommand()->insert(self::tableName(), $data)->execute();
        return $rs;
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