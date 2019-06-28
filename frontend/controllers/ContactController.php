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
    public $enableCsrfValidation = false;
    public $layout = 'index';

    public function actions()
    {
        return [
            'index' => [
                'class' => 'frontend\actions\Contact\IndexAction'
            ],
            'reply' => [
                'class' => 'frontend\actions\Contact\ReplyAction'
            ]
        ];
    }
}