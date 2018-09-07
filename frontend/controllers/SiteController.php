<?php
/**
 * Message: 网站主页
 * User: jzc
 * Date: 2018/9/6
 * Time: 下午11:17
 * Return:
 */

namespace frontend\controllers;



class SiteController extends CommonController
{
    public $layout = 'index';
    public function actionIndex()
    {
        return $this->render('index');
    }
}
