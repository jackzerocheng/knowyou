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

    public function getCountByCondition($condition)
    {
        $db = self::find();
        $db = $this->handlerCondition($db, $condition);
        return intval($db->count());
    }

    public function insertInfo($data)
    {
        $rs = Yii::$app->db->createCommand()->insert(static::tableName(), $data)->execute();
        return $rs;
    }

    /**
     * @param $db ActiveQuery
     * @param $condition
     * @return ActiveQuery
     */
    public function handlerCondition($db, $condition)
    {
        if (!empty($condition) && is_array($condition)) {
            foreach ($condition as $k => $v) {
                if ($k == 'start_id') {
                    $db = $db->andWhere("id > {$v}");
                } elseif($k == 'max_id') {
                    $db = $db->andWhere("id < {$v}");
                } elseif ($k == 'start_at') {
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