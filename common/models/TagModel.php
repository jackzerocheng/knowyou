<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/10/30
 * Time: 5:34 PM
 * Return:
 */

namespace common\models;

use common\cache\Tag\TagCache;
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

    public function getTagInfo($condition, $useCache = true)
    {
        $tagInfo = array();
        if ($useCache) {//查询缓存
            $tagInfo = (new TagCache())->getTagInfo($condition);
        }

        if (empty($tagInfo)) {
            $list = $this->getListByCondition($condition);
            foreach ($list as $_list) {
                $tagInfo[$_list['type']] = $_list;
            }

            //添加缓存
            (new TagCache())->setTagInfo(json_encode($tagInfo));
        }

        return $tagInfo;
    }

    public function getOneByCondition($condition = null)
    {
        return (new Tag())->getOneByCondition($condition);
    }

    public function getListByCondition($condition = null)
    {
        return (new Tag())->getListByCondition($condition);
    }
}