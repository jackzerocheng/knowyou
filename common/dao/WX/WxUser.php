<?php
/**
 * Message: 微信用户
 * User: jzc
 * Date: 2019/2/13
 * Time: 1:45 PM
 * Return:
 */

namespace common\dao\WX;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class WxUser extends ActiveRecord
{
    public static function getDb()
    {
        return Yii::$app->get('db_wx');
    }

    public static function tableName()
    {
        return 'wx_user';
    }

    public function insertData(array $data)
    {
        $data['created_at'] = empty($data['created_at']) ? NOW_DATE : $data['created_at'];

        $rs = self::getDb()->createCommand()->insert(self::tableName(), $data)->execute();
        return $rs;
    }

    public function updateData(array $info, $condition)
    {
        $info['updated_at'] = empty($info['updated_at']) ? NOW_DATE : $info['updated_at'];

        $rs = self::getDb()->createCommand()->update(self::tableName(), $info, $condition)->execute();
        return $rs;
    }

    public function getOneByCondition($condition)
    {
        $db = self::find();
        $db = self::handlerCondition($db, $condition);

        return $db->asArray()->one();
    }

    public function getCountByCondition($condition)
    {
        $db = self::find()->from(self::tableName());
        $db = $this->handlerCondition($db, $condition);

        return intval($db->count());
    }

    public function getListByCondition($condition,$limit = 10, $offset = 0, $orderBy = 'created_at desc')
    {
        $db = self::find();
        $db = self::handlerCondition($db, $condition);

        return $db->offset($offset)->limit($limit)->orderBy($orderBy)->asArray()->all();
    }

    /**
     * @param $db
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