<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/12/4
 * Time: 3:53 PM
 * Return:
 */

namespace console\controllers\crontab;

use Yii;

class TestCodeController extends BaseController
{
    public function actionIndex()
    {
        Yii::info('test:'.time(), CATEGORIES_CONSOLE);
    }
}