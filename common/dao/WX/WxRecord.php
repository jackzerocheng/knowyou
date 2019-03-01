<?php
/**
 * Message:
 * User: jzc
 * Date: 2019/1/29
 * Time: 5:58 PM
 * Return:
 */

namespace common\dao\WX;

use Yii;
use yii\db\ActiveRecord;

class WxRecord extends ActiveRecord
{
    public static function getDb()
    {
        return Yii::$app->get('db_wx');
    }

    public static function tableName()
    {
        return 'wx_record';
    }

    public function insertData(array $data)
    {
        $data['created_at'] = !empty($data['created_at']) ? $data['created_at'] : NOW_DATE;

        $rs = self::getDb()->createCommand()->insert(self::tableName(), $data)->execute();
        return $rs;
    }

    /**
     * @param $condition
     * @param string $orderBy
     * @param int $limit
     * @param $offset
     * @return mixed
     */
    public function getListByCondition($condition, $limit = 1000, $offset = 0, $orderBy = 'created_at desc')
    {
        $db = self::find()->from(self::tableName());
        $db = $this->handlerCondition($db, $condition);

        $rs = $db->offset($offset)->limit($limit)->orderBy($orderBy)->asArray()->all();
        return $rs;
    }

    /**
     * @param $condition
     * @return int
     */
    public function getCountByCondition($condition)
    {
        $db = self::find()->from(self::tableName());
        $db = $this->handlerCondition($db, $condition);

        return intval($db->count());
    }

    public function handlerCondition($db, $condition)
    {
        if (!empty($condition) && is_array($condition)) {
            foreach ($condition as $k => $v) {
                if ($k == 'search') {
                    $db = $db->orWhere("title like '%{$v}%'");
                    $db = $db->orWhere("content like '%{$v}%'");
                } else {
                    $db = $db->andWhere([$k => $v]);
                }
            }
        }

        return $db;
    }
}