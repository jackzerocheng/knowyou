<?php
namespace api\controllers;

use common\lib\Config;
use Yii;
use common\lib\CryptAes;
/**
 * Site controller
 */
class SiteController extends CommonController
{
    public function actionIndex()
    {
        $this->outputJson('success');
    }
}
