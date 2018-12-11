<?php
/**
 * Message: 文章索引
 * User: jzc
 * Date: 2018/12/10
 * Time: 10:39 PM
 * Return:
 */

namespace common\models;

use yii\base\Model;
use common\dao\ArticleIndex;

class ArticleIndexModel extends Model
{
    public function getArticleByTime($limit = 10, $offset = 0)
    {
        
        $ids = (new ArticleIndex())->getListByCondition([], $limit, $offset);
    }
}