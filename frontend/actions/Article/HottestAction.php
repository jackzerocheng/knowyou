<?php
/**
 * Message: 最热文章列表
 * User: jzc
 * Date: 2019/7/9
 * Time: 1:55 PM
 * Return:
 */

namespace frontend\actions\Article;


use common\models\ArticleModel;
use frontend\actions\BaseAction;
use common\models\TagModel;

class HottestAction extends BaseAction
{
    public function run()
    {
        $articleModel = new ArticleModel();

        $hottestList = $articleModel->getHottestArticle();
        if (!empty($hottestList)) {
            foreach ($hottestList as $k => $v) {
                $hottestList[$k]['redis_read_number'] = $articleModel->getArticleReadNumber($v['id']);
            }
        }

        $tagMap = (new TagModel())->getTagInfo(['status' => TagModel::TAG_STATUS_USING]);


        return $this->controller->render('hottest', ['article_list'=>$hottestList, 'tag'=> $tagMap]);
    }
}