<?php
namespace api\controllers;

use common\lib\Config;
use Yii;
/**
 * Site controller
 */
class SiteController extends CommonController
{
    public function actionIndex()
    {
        $this->outputJson('success');

        echo "api";
    }
}
