<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/12/25
 * Time: 2:09 PM
 * Return:
 */

namespace common\dao;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use Yii;

class UserIndex extends ActiveRecord
{
    protected static $tableName = '';

    public function __construct($key = 0, array $config = [])
    {
        parent::__construct($config);
        static::$tableName = '{{%user_index0' . $key . '}}';
    }

    public static function tableName()
    {
        return static::$tableName;
    }

    public function getMaxID()
    {
        $rs = Yii::$app->db->createCommand('select max(id) as max_id from knowyou_user_index00')->queryOne();
        return $rs['max_id'] ? intval($rs['max_id']) : 0;
    }

    public function insertInfo($data)
    {
        $rs = Yii::$app->db->createCommand()->insert(static::tableName(), $data)->execute();
        return $rs;
    }
}