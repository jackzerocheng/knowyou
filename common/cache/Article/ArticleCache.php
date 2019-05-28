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
    const CACHE_ARTICLE_READ_NUMBER = 'article_read_number:';

    public function getArticleReadNumber($id)
    {
        return intval($this->get(self::CACHE_ARTICLE_READ_NUMBER . $id));
    }

    public function incrArticleReadNumber($id)
    {
        $number = $this->getArticleReadNumber($id);

        $this->set(self::CACHE_ARTICLE_READ_NUMBER . $id, ++$number, ONE_MONTH);

        return $number;
    }
}