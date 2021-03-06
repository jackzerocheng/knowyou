<?php
/**
 * Message: 标签cache
 * User: jzc
 * Date: 2019/5/28
 * Time: 11:40 PM
 * Return:
 */

namespace common\cache\Tag;


use common\cache\BaseCache;

class TagCache extends BaseCache
{
    const CACHE_TAG_INFO = 'tag_info:';

    /**
     * 获取缓存中的Tag列表
     * @param null $condition //仅支持普通一维数组等值检索
     * @return array
     */
    public function getTagInfo($condition = null)
    {
        $rs = array();

        $data = $this->get(self::CACHE_TAG_INFO);
        if (!empty($data)) {
            $data = json_decode($data, true);
            if (!empty($condition)) {//过滤筛选条件
                foreach ($data as $k => $v) {
                    $match = true;
                    foreach ($condition as $conKey => $conVal) {
                        if ($v[$conKey] != $conVal) {
                            $match = false;
                        }
                    }

                    if ($match) {
                        $rs[$k] = $v;
                    }
                }
            }
        }

        return $rs;
    }

    public function setTagInfo($value)
    {
        return $this->set(self::CACHE_TAG_INFO, $value, ONE_MONTH);
    }
}