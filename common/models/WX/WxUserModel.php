<?php
/**
 * Message: 微信用户数据
 * User: jzc
 * Date: 2019/2/13
 * Time: 1:56 PM
 * Return:
 */

namespace common\models\WX;

use common\dao\WX\WxUser;
use yii\base\Model;
use Yii;

class WxUserModel extends Model
{

    const EVENT_SUBSCRIBE = 1;
    const EVENT_UNSUBSCRIBE = 2;
    const EVENT_UNKNOWN = 'unknown';
    public $eventMap = [
        self::EVENT_SUBSCRIBE => '订阅',
        self::EVENT_UNSUBSCRIBE => '取消订阅'
    ];

    public function insert(array $data)
    {
        $rs = (new WxUser())->insertData($data);
        if (!$rs) {
            Yii::error('insert data to wx_user failed;data:'.json_encode($data), CATEGORIES_ERROR);
        }

        return $rs;
    }

    public function update(array $info, $condition)
    {
        $rs = (new WxUser())->updateData($info, $condition);
        if (!$rs) {
            Yii::error('update data to wx_user failed;data:'.json_encode($info), CATEGORIES_ERROR);
        }

        return $rs;
    }

    public function getOneByCondition($condition)
    {
        return (new WxUser())->getOneByCondition($condition);
    }

    public function getCountByCondition($condition)
    {
        return (new WxUser())->getCountByCondition($condition);
    }

    public function getListByCondition($condition, $limit, $offset)
    {
        $list = (new WxUser())->getListByCondition($condition, $limit, $offset);
        if (!empty($list)) {
            foreach ($list as $k => $v) {
                $list[$k]['status_msg'] = $this->eventMap[$v['status']];
            }
        }

        return $list;
    }
}