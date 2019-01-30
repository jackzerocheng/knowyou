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
        $data['created_at'] = $data['created_at'] ?: NOW_DATE;

        $rs = self::getDb()->createCommand()->insert(self::tableName(), $data)->execute();
        return $rs;
    }
}