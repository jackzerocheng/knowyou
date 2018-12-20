<?php
namespace backend\controllers;

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

        return $this->render('index', ['user_info' => $userInfo]);
    }

    public function actionMain()
    {
        return $this->render('main');
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }

        return true;
    }
}
