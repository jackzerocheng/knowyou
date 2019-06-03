<?php
/**
 * Message: 文章cache
 * User: jzc
 * Date: 2019/5/28
 * Time: 10:24 PM
 * Return:
 */

namespace common\cache\Article;

use common\cache\BaseCache;

class ArticleCache extends BaseCache
{
    const CACHE_ARTICLE_INFO = 'article_info:';

    public function getArticleInfo($id)
    {
        $rs = [];
        $data = $this->get(self::CACHE_ARTICLE_INFO . $id);
        if (!empty($data)) {
            $rs = json_decode($data, true);
        }

        return $rs;
    }

    public function setArticleInfo($id, $value)
    {
        return $this->set(self::CACHE_ARTICLE_INFO . $id, $value, ONE_MONTH);
    }
}