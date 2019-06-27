<?php
/**
 * Message: 联系controller
 * User: jzc
 * Date: 2019/6/4
 * Time: 1:57 PM
 * Return:
 */

namespace frontend\controllers;


class ContactController extends CommonController
{
    public $layout = 'index';
    public function actions()
    {
        return [
            'test' => [
                'class' => 'frontend\actions\Contact\IndexAction'
            ]
        ];
    }

    public function actionIndex()
    {
        echo 'index';
    }
}