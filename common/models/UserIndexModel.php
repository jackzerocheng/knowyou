<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/12/25
 * Time: 2:17 PM
 * Return:
 */

namespace common\models;

use common\dao\UserIndex;
use yii\base\Model;
use Yii;

class UserIndexModel extends Model
{
    const USER_NUMBER_COUNT = 'USER_NUMBER_COUNT';//用户总数记录
    const MAX_RECORD_NUMBER = 10000000;//一千万

    /**
     * 获取当前用户计数
     * @return int
     */
    public function getUserCountNumber()
    {
        $redis = Yii::$app->redis;
        if ($redis->exists(self::USER_NUMBER_COUNT)) {
            return $redis->get(self::USER_NUMBER_COUNT);
        } else {
            return (new UserIndex())->getMaxID();
        }
    }

    /**
     * 插入用户索引，返回索引ID
     * @param $uid
     * @return integer
     */
    public function insert($uid)
    {
        $redis = Yii::$app->redis;
        if (!$redis->exists(self::USER_NUMBER_COUNT)) {
            $redis->set(self::USER_NUMBER_COUNT, 0);
        }

        $id = $redis->incr(self::USER_NUMBER_COUNT);
        $key = intval($id / self::MAX_RECORD_NUMBER);
        $data = [
            'id' => $id,
            'uid' => $uid,
            'created_at' => NOW_DATE
        ];

        $rs = (new UserIndex($key))->insertInfo($data);
        if (!$rs) {
            Yii::error('insert index info failed;msg:'.json_encode($data), CATEGORIES_ERROR);
            return 0;
        }

        Yii::info("insert index info;id:{$id}", CATEGORIES_INFO);
        return $id;
    }
}