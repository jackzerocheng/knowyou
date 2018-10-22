<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/10/22
 * Time: 3:31 PM
 * Return:
 */

namespace common\models;

use yii\base\Model;
use common\dao\Article;

class ArticleModel extends Model
{
    public function getListByCondition($condition = null, $limit = 100)
    {
        $count = Article::TABLE_PARTITION;
        $result = array();

        while ($count - Article::TABLE_PARTITION < Article::TABLE_PARTITION) {
            $article = new Article($count);
            $result = array_merge($result, $article->getListByCondition($condition, $limit));
            $count++;
        }

        return $result;
    }
}