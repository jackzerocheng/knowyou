<?php
/**
 * Message: 微信消息过滤
 * User: jzc
 * Date: 2019/1/30
 * Time: 10:32 AM
 * Return:
 */

namespace common\models\WX;

use common\dao\WX\WxRules;
use yii\base\Model;

class WxRulesModel extends Model
{
    const STATUS_OPEN = 1;
    const STATUS_CLOSED = 2;
    const STATUS_DELETED = 3;

    public function getListByCondition($condition)
    {
        return (new WxRules())->getListByCondition($condition);
    }
}