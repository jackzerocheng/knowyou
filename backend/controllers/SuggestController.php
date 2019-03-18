<?php
/**
 * Message: 留言处理
 * User: jzc
 * Date: 2019/3/13
 * Time: 2:19 PM
 * Return:
 */

namespace backend\controllers;

use common\models\SuggestModel;
use yii\data\Pagination;

class SuggestController extends CommonController
{
    /*
     * 留言列表
     */
    public function actionIndex()
    {
        $suggestModel = new SuggestModel();

        //分页
        $count = $suggestModel->getCountByCondition([]);
        $page = new Pagination(['totalCount' => $count, 'pageSize' => '10']);
        $suggestList = array();
        if ($count > 0) {
            $suggestList = $suggestModel->getListByCondition([], $page->limit, $page->offset);
        }

        return $this->render('index', ['data' => $suggestList, 'pages' => $page]);
    }
}