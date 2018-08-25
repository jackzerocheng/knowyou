<?php
namespace frontend\controllers;

use yii\web\Controller;
use common\models\User;

class SiteController extends Controller
{
    public $layout = 'index';

    public function actionIndex()
    {
        $userModel = new User();

        return $this->render('index', ['model' => $userModel]);
    }
}
