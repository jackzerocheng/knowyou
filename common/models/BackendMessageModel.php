<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/12/24
 * Time: 8:29 PM
 * Return:
 */

namespace common\models;


use yii\base\Model;
use common\dao\BackendMessage;

class BackendMessageModel extends Model
{
    const MESSAGE_STATUS_NOT_REPLY = 1;//未回复
    const MESSAGE_STATUS_REPLIED = 2;//已回复
    const MESSAGE_STATUS_DELETED = 3;//删除
    public $messageMap = [
        self::MESSAGE_STATUS_NOT_REPLY => '未回复',
        self::MESSAGE_STATUS_REPLIED => '已回复',
        self::MESSAGE_STATUS_DELETED => '删除'
    ];

    /**
     * 获取留言数
     * @param $condition array
     * @return int
     */
    public function getCountByCondition($condition)
    {
        return (new BackendMessage())->getCountByCondition($condition);
    }

    /**
     * 分页获取留言列表
     * @param $condition
     * @param int $limit
     * @param int $offset
     * @param string $orderBy
     * @return mixed
     */
    public function getListByCondition($condition, $limit = 1000, $offset = 0, $orderBy = 'created_at desc')
    {
        return (new BackendMessage())->getListByCondition($condition, $limit, $offset, $orderBy);
    }
}