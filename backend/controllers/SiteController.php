<?php
namespace backend\controllers;

use Yii;

/**
 * Site controller
 */
class SiteController extends CommonController
{
    public function actionIndex()
    {
        return $this->renderPartial('index');
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
