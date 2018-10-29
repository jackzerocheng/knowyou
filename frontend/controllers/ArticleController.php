<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/10/29
 * Time: 4:19 PM
 * Return:
 */

namespace frontend\controllers;

use common\models\ArticleModel;
use common\lib\Request;
use Yii;

class ArticleController extends CommonController
{
    public $layout = 'index';

    public function actionIndex()
    {
        $articleModel = new ArticleModel();
        $id = (new Request())->get('id');
        $id = 
        if (empty($id)) {
            Yii::$app->session->setFlash('message', '对不起，你访问的页面不存在哦');
            return $this->redirect(['site/index']);
        }

        $articleInfo = $articleModel->getOneByCondition($id, ['id' => $id]);
        $readNumber = $articleModel->getReadNumber($id);
        if (empty($articleInfo)) {
            Yii::$app->session->setFlash('message', '主人，我没找到你想要的！');
            return $this->redirect(['site/index']);
        }

        $data = [
            'article_info' => $articleInfo,
            'read_number' => $readNumber,
            'username' => $this->username
        ];
        return $this->render('article', $data);
    }
}