<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/12/3
 * Time: 2:58 PM
 * Return:
 */

namespace common\models;

use yii\base\Model;
use common\dao\Praise;

class PraiseModel extends Model
{
    const PRAISE_STATUS_SUCCESS = 1;//成功
    const PRAISE_STATUS_CANCEL = 2;//取消

    /**
     * 查询是否点赞
     * @param $articleID
     * @param $condition
     * @return mixed
     */
    public function getOneByCondition($articleID, $condition)
    {
        return (new Praise($articleID))->getOneByCondition($condition);
    }

    /**
     * 插入一条点赞记录
     * @param $articleID
     * @param $data
     * @return bool
     */
    public function insert($articleID, $data)
    {
        return (new Praise($articleID))->insert(true, $data);
    }
}