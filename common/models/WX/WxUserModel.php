<?php
/**
 * Message:
 * User: jzc
 * Date: 2019/2/13
 * Time: 1:56 PM
 * Return:
 */

namespace common\models\WX;

use common\dao\WX\WxUser;
use yii\base\Model;

class WxUserModel extends Model
{
    const STATUS_NORMAL = 1;
    const STATUS_DELETED = 2;//已取消订阅

    const EVENT_SUBSCRIBE = 1;
    const EVENT_UNSUBSCRIBE = 2;
    public $eventMap = [
        self::EVENT_SUBSCRIBE => '订阅',
        self::EVENT_UNSUBSCRIBE => '取消订阅'
    ];

    public function insert(array $data)
    {
        return (new WxUser())->insertData($data);
    }
}