<?php
namespace backend\controllers;

use common\models\MenuModel;
use Yii;
use common\models\AdminModel;

/**
 * Site controller
 */
class SiteController extends CommonController
{
    public function actionIndex()
    {
        $adminModel = new AdminModel();
        $userInfo = $adminModel->getOneByCondition(['admin_id' => $this->uid]);
        if (empty($userInfo)) {
            Yii::$app->session->setFlash('error', '用户信息为空');
            return Yii::$app->response->redirect(['login/index']);
        }

        $menuInfo = (new MenuModel())->getMenuList(MenuModel::MENU_TYPE_BACKEND);

        $data = [
            'user_info' => $userInfo,
            'menu_info' => $menuInfo
        ];
        return $this->render('index', $data);
    }

    //内嵌子页面
    public function actionMain()
    {
        return $this->render('main');
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
