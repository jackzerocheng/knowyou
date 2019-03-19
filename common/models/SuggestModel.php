<?php
/**
 * Message: 留言Model
 * User: jzc
 * Date: 2019/3/13
 * Time: 10:15 AM
 * Return:
 */

namespace common\models;

use yii\base\Model;
use common\dao\Suggest;
use Yii;

class SuggestModel extends Model
{
    const TYPE_UNDEFINED = 0;
    const TYPE_WX = 1;//微信留言
    const TYPE_WEB = 2;//网站留言
    public $typeMap = [
        self::TYPE_UNDEFINED => '未定义',
        self::TYPE_WX => '微信',
        self::TYPE_WEB => '网站'
    ];

    const STATUS_NOT_REPLY = 1;//未回复
    const STATUS_REPLIED = 2;//已回复
    const STATUS_DELETED = 3;//已删除
    public $statusMap = [
        self::STATUS_NOT_REPLY => '未回复',
        self::STATUS_REPLIED => '已回复',
        self::STATUS_DELETED => '已删除'
    ];

    public function insert($data)
    {
        $rs = (new Suggest())->insert($data);
        if (!$rs) {
            Yii::error('insert data to suggest failed;data:'.json_encode($data), CATEGORIES_ERROR);
        }

        return $rs;
    }

    public function getListByCondition($condition, $limit, $offset)
    {
        $list = (new Suggest())->getListByCondition($condition, $limit, $offset);

        if (!empty($list)) {
            foreach ($list as $k => $v) {
                $list[$k]['status_msg'] = $this->statusMap[$v['status']];
                $list[$k]['type_msg'] = $this->typeMap[$v['type']];
            }
        }

        return $list;
    }

    public function getCountByCondition($condition)
    {
        return (new Suggest())->getCountByCondition($condition);
    }
}