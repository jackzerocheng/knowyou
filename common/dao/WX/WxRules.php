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
    public static function getDb()
    {
        return Yii::$app->get('db_wx');
    }

    public static function tableName()
    {
        return 'wx_rules';
    }

    public function insertData(array $data)
    {
        $data['created_at'] = empty($data['created_at']) ? NOW_DATE : $data['created_at'];

        $rs = self::getDb()->createCommand()->insert(self::tableName(), $data)->execute();
        return $rs;
    }

    public function updateData(array $data, $condition)
    {
        $rs = self::getDb()->createCommand()->update(self::tableName(), $data, $condition)->execute();
        return $rs;
    }

    public function getOneByCondition($condition)
    {
        $db = self::find();
        $db = self::handlerCondition($db, $condition);

        return $db->asArray()->one();
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
                $db = $db->andWhere([$k => $v]);
            }
        }

        return $db;
    }
}