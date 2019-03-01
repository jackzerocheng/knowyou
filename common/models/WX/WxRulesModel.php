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
    public $statusMap = [
        self::STATUS_OPEN => '打开',
        self::STATUS_CLOSED => '关闭',
        self::STATUS_DELETED => '删除'
    ];

    const TYPE_KEY_WORD = 1;//关键词自动回复
    const TYPE_ILLEGAL_WORD = 2;//敏感词做替换
    public $typeMap = [
        self::TYPE_KEY_WORD => '关键词',
        self::TYPE_ILLEGAL_WORD => '敏感词'
    ];

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

    public function getListByCondition($condition, $limit, $offset)
    {
        $list =  (new WxRules())->getListByCondition($condition, $limit, $offset);
        foreach ($list as $k => $v) {
            $list[$k]['status_msg'] = $this->statusMap[$v['status']];
            $list[$k]['type_msg'] = $this->typeMap[$v['type']];
        }

        return $list;
    }

    public function getCountByCondition($condition)
    {
        return (new WxRules())->getCountByCondition($condition);
    }

    public function getOneByCondition($condition)
    {
        return (new WxRules())->getOneByCondition($condition);
    }

    public function update($data)
    {
        return (new WxRules())->updateData($data);
    }
}