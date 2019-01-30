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

    const TYPE_KEY_WORD = 1;//关键词自动回复
    const TYPE_ILLEGAL_WORD = 2;//敏感词做替换

    /**
     * 获取 key=>value 映射
     * @param $condition
     * @return array
     */
    public function getRuleKeys($condition)
    {
        $list = (new WxRules())->getListByCondition($condition);
        $rs = array();

        if (!empty($list)) {
            foreach ($list as $_rule) {
                $rs[$_rule['key_word']] = $_rule['to_word'];
            }
        }

        return $rs;
    }
}