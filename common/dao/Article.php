<?php
/**
 * Message: 文章Model
 * User: jzc
 * Date: 2018/10/18
 * Time: 下午6:37
 * Return:
 */

namespace common\dao;

use yii\db\ActiveRecord;
use Yii;

class Article extends ActiveRecord
{
    const BASE_ARTICLE_ID = 'BASE_ARTICLE_ID';//id = base_id * partition + uid % partition
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

    public function insert($runValidation = true, $data = null)
    {
        $data['created_at'] = empty($data['created_at']) ? NOW_DATE : $data['created_at'];
        $id = Yii::$app->redis->incr(self::BASE_ARTICLE_ID) * self::TABLE_PARTITION + $data['uid'] % self::TABLE_PARTITION;
        $data['id'] = $id;

        if (!self::getDb()->schema->insert(static::tableName(), $data)) {
            return false;
        }

        return $id;
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