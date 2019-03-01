<?php
/**
 * Message: 公众号接收消息记录
 * User: jzc
 * Date: 2019/1/29
 * Time: 6:56 PM
 * Return:
 */

namespace common\models\WX;

use common\dao\WX\WxRecord;
use yii\base\Model;

class WxRecordModel extends Model
{
    const MSG_TYPE_TEXT = 1;//文本
    const MSG_TYPE_IMAGE = 2;//图片
    const MSG_TYPE_VOICE = 3;//语音
    const MSG_TYPE_VIDEO = 4;//视频
    const MSG_TYPE_SHORT_VIDEO = 5;//小视频
    const MSG_TYPE_LOCATION = 6;//地理位置
    const MSG_TYPE_LINK = 7;//链接消息
    public $typeMap = [
        self::MSG_TYPE_TEXT => 'text',
        self::MSG_TYPE_IMAGE => 'image',
        self::MSG_TYPE_VOICE => 'voice',
        self::MSG_TYPE_VIDEO => 'video',
        self::MSG_TYPE_SHORT_VIDEO => 'shortvideo',
        self::MSG_TYPE_LOCATION => 'location',
        self::MSG_TYPE_LINK => 'link'
    ];

    public function insert($data)
    {
        return (new WxRecord())->insertData($data);
    }

    public function getListByCondition($condition, $limit, $offset)
    {
        return (new WxRecord())->getListByCondition($condition, $limit, $offset);
    }

    public function getCountByCondition($condition)
    {
        return (new WxRecord())->getCountByCondition($condition);
    }
}