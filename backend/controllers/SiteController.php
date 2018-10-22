<?php
namespace backend\controllers;

use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends CommonController
{
    public function actionIndex()
    {
        return $this->renderPartial('index');
    }
}
