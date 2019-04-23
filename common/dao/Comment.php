<?php
/**
 * Message: 评论DAO
 * User: jzc
 * Date: 2018/10/30
 * Time: 5:55 PM
 * Return:
 */

namespace common\dao;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use Yii;

class Comment extends ActiveRecord
{
    const TABLE_PARTITION = 4;
    protected static $tableName = '';

    public function __construct($id, array $config = [])
    {
        parent::__construct($config);
        static::$tableName = '{{%comment0' . $id % self::TABLE_PARTITION . '}}';
    }

    public static function tableName()
    {
        return static::$tableName;
    }

    public function insertData($info)
    {
        $info['created_at'] = !empty($info['created_at']) ? $info['created_at'] : NOW_DATE;

        $rs = Yii::$app->db->createCommand()->insert(self::$tableName, $info)->execute();
        return $rs;
    }

    public function getCountByCondition($condition)
    {
        $db = self::find();
        $db = self::handlerCondition($db, $condition);

        return intval($db->count());
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
        $db = self::find()->from(self::$tableName);
        $db = $this->handlerCondition($db, $condition);

        $rs = $db->offset($offset)->limit($limit)->orderBy($orderBy)->asArray()->all();
        return $rs;
    }

    public function getAllList($condition, $limit = 100000, $orderBy = 'created_at asc')
    {
        $db = self::find()->from(self::$tableName);
        $db = $this->handlerCondition($db, $condition);

        $rs = $db->limit($limit)->orderBy($orderBy)->asArray()->all();
        return $rs;
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