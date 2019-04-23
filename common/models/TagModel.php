<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/10/30
 * Time: 5:34 PM
 * Return:
 */

namespace common\models;

use yii\base\Model;
use common\dao\Tag;

class TagModel extends Model
{
    const TAG_STATUS_USING = 1;
    const TAG_STATUS_STOPPED = 2;
    const TAG_STATUS_DELETED = 3;

    const TAG_TYPE_UNDEFINED = 1;
    public $tagMap = [
        self::TAG_TYPE_UNDEFINED => '未分类'
    ];

    public function getOneByCondition($condition = null)
    {
        return (new Tag())->getOneByCondition($condition);
    }

    public function getListByCondition($condition = null)
    {
        return (new Tag())->getListByCondition($condition);
    }
}