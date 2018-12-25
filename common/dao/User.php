<?php
/**
 * Message: 用户Model
 * User: jzc
 * Date: 2018/8/25
 * Time: 下午6:59
 * Return:
 */

namespace common\dao;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use Yii;

class User extends ActiveRecord
{
    const BASE_USER_ID_KEY = 'BASE_USER_ID';
    const BASE_USER_ID = 10000000;

    const TABLE_PARTITION = 4;//分表数

    public static $uid;
    protected static $tableName = '';

    /**
     * User constructor.
     * @param string $uid
     * @param array $config
     */
    public function __construct($uid = -1, array $config = [])
    {
        parent::__construct($config);
        static::$tableName = static::getTableName($uid);
    }

    public static function tableName()
    {
        return static::$tableName;
    }

    private static function getTableName($uid)
    {
        if ($uid == -1) {
            $uid = static::getUid();
        }

        return '{{%user0' . $uid % self::TABLE_PARTITION . '}}';
    }

    /**
     * 依赖Redis返回生成的UID
     * @return int
     */
    private static function getUid()
    {
        $redis = Yii::$app->redis;
        if (!$redis->exists(self::BASE_USER_ID_KEY)) {
            $redis->set(self::BASE_USER_ID_KEY, self::BASE_USER_ID);
        }

        static::$uid = $redis->incr(self::BASE_USER_ID_KEY);
        return static::$uid;
    }

    public function insert($runValidation = true, $data = null)
    {
        $data['created_at'] = empty($data['created_at']) ? NOW_DATE : $data['created_at'];
        $data['uid'] = empty($data['uid']) ? self::$uid : $data['uid'];

        return self::getDb()->schema->insert(static::tableName(), $data);
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