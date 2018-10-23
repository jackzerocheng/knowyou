<?php
/**
 * Message: 用户Model
 * User: jzc
 * Date: 2018/8/25
 * Time: 下午6:59
 * Return:
 */

namespace common\dao;

use yii\db\ActiveRecord;
use Yii;

class User extends ActiveRecord
{
    const BASE_USER_ID = 'BASE_USER_ID';

    const TABLE_PARTITION = 4;//分表数

    public static $uid;
    protected static $tableName = '';

    public function __construct($uid = 0, array $config = [])
    {
        parent::__construct($config);
        static::$tableName = static::getTableName($uid);
    }

    public static function tableName()
    {
        return static::$tableName;
    }

    private static function getTableName($uid = 0)
    {
        $uid = $uid ? : static::getUid();
        return '{{%user0' . $uid % self::TABLE_PARTITION . '}}';
    }

    /**
     * 依赖Redis返回生成的UID
     * @return int
     */
    private static function getUid()
    {
        $redis = Yii::$app->redis;
        static::$uid = $redis->incr(self::BASE_USER_ID);
        return static::$uid;
    }

    public function insert($runValidation = true, $data = null)
    {
        $data['created_at'] = empty($data['created_at']) ? NOW_DATE : $data['created_at'];
        $data['uid'] = empty($data['uid']) ? self::$uid : $data['uid'];

        return self::getDb()->schema->insert(static::tableName(), $data);
    }

    public function getOneByCondition($condition = null)
    {
        $db = self::find();
        $db = self::handlerCondition($db, $condition);

        return $db->asArray()->one();
    }

    public function getCountByCondition($condition = null)
    {
        $db = self::find();
        $db = self::handlerCondition($db, $condition);

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