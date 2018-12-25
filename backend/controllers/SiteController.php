<?php
namespace backend\controllers;

use common\models\ArticleIndexModel;
use common\models\BackendMessageModel;
use common\models\MenuModel;
use common\models\UserIndexModel;
use common\models\UserModel;
use Yii;
use common\models\AdminModel;
use common\lib\Config;

/**
 * Site controller
 */
class SiteController extends CommonController
{
    public function actionIndex()
    {
        $adminModel = new AdminModel();
        //用户信息
        $userInfo = $adminModel->getOneByCondition(['admin_id' => $this->uid]);
        if (empty($userInfo)) {
            Yii::$app->session->setFlash('error', '用户信息为空');
            return Yii::$app->response->redirect(['login/index']);
        }

        //菜单
        $menuInfo = (new MenuModel())->getMenuList(MenuModel::MENU_TYPE_BACKEND);

        //通知弹窗内容
        $notice = (new Config())->getEnv('backend/notice.default');

        $data = [
            'user_info' => $userInfo,
            'menu_info' => $menuInfo,
            'notice' => $notice
        ];
        return $this->render('index', $data);
    }

    //内嵌子页面
    public function actionMain()
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

        return $this->render('main', ['count_number' => $countNumber]);
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
            return $this->renderPartial('error');
        }

        return true;
    }
}
