<?php
namespace backend\controllers;

use common\models\ArticleIndexModel;
use common\models\BackendMessageModel;
use common\models\UserIndexModel;
use Yii;
use common\models\AdminModel;

/**
 * Site controller
 */
class SiteController extends CommonController
{
    public function actionIndex()
    {
        $params = ['start_at' => TODAY,'end_at' => TOMORROW];
        //聚合汇总数量
        $countNumber = [
            'today_message_number' => (new BackendMessageModel())->getCountByCondition($params),//今日留言
            'today_new_user_number' => (new UserIndexModel())->getUserCountNumber($params),//今日注册数
            'all_user_number' => (new UserIndexModel())->getUserCountNumber([]),//总用户量
            'today_article_number' => (new ArticleIndexModel())->getArticleNumberCount($params),//今日文章数
            'all_article_number' => (new ArticleIndexModel())->getArticleNumberCount([]),//总文章数
        ];

        $data = [
            'count_number' => $countNumber
        ];
        return $this->render('main', $data);
    }

    public function actionLogout()
    {
        Yii::info("user logout;uid:".$this->uid, CATEGORIES_INFO);
        Yii::$app->session->remove(AdminModel::ADMIN_USER_SESSION_KEY);
        Yii::$app->session->destroy();
        return Yii::$app->response->redirect(['login/index']);
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error');
        }

        return $this->render('error');
    }
}
