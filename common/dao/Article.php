<?php
/**
 * Message: 文章dao
 * User: jzc
 * Date: 2018/10/18
 * Time: 下午6:37
 * Return:
 */

namespace common\dao;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use Yii;
use yii\db\Expression;

class Article extends ActiveRecord
{
    const TABLE_PARTITION = 4;
    protected static $tableName = '';

    public function __construct($uid = 0, array $config = [])
    {
        parent::__construct($config);
        static::$tableName = '{{%article0' . $uid % self::TABLE_PARTITION . '}}';
    }

    public static function tableName()
    {
        return static::$tableName;
    }

    public function insertData($data = array())
    {
        $data['created_at'] = empty($data['created_at']) ? NOW_DATE : $data['created_at'];

        $rs = Yii::$app->db->createCommand()->insert(static::$tableName, $data)->execute();
        return $rs;
    }

    public function insertBatch($data)
    {
        return Yii::$app->db->createCommand()->batchInsert(self::tableName(),array_keys($data), $data)->execute();
    }

    public function updateBatch($data, $index)
    {
        $sql = "";
        $tableName = self::tableName();
        foreach ($data as $line) {
            $head = "update {$tableName} set ";
            foreach ($line as $k => $v) {
                $head = $head . "{$k} = {$v},";
            }

            $head = substr($head, 0, strlen($head) - 1);//去掉多余逗号
            $head = $head . " where {$index} = {$line[$index]};\n";//拼接条件

            $sql = $sql . $head;
        }

        return Yii::$app->db->createCommand($sql)->execute();
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

    public function getAllList($condition, $limit, $orderBy = 'created_at desc')
    {
        $db = self::find()->from(self::$tableName);
        $db = $this->handlerCondition($db, $condition);

        $rs = $db->limit($limit)->orderBy($orderBy)->asArray()->all();
        return $rs;
    }

    /**
     * @param $condition
     * @return mixed
     */
    public function getOneByCondition($condition)
    {
        $db = self::find()->from(self::$tableName);
        $db = $this->handlerCondition($db, $condition);

        $rs = $db->asArray()->one();
        return $rs;
    }

    /**
     * @param $condition
     * @return int
     */
    public function getCountByCondition($condition)
    {
        $db = self::find()->from(self::$tableName);
        $db = $this->handlerCondition($db, $condition);

        return intval($db->count());
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
                if ($k == 'search') {
                    $db = $db->orWhere("title like '%{$v}%'");
                    $db = $db->orWhere("content like '%{$v}%'");
                } elseif ($k == 'start_at') {
                    $db = $db->andWhere("created_at >= {$v}");
                } elseif ($k == 'end_at') {
                    $db = $db->andWhere("created_at < {$v}");
                } else {
                    $db = $db->andWhere([$k => $v]);
                }
            }
        }

        return $db;
    }
}