<?php
/**
 * Message: 独立action测试
 * User: jzc
 * Date: 2019/6/3
 * Time: 10:16 PM
 * Return:
 */

namespace frontend\actions\Test;


use yii\base\Action;

class TestAction extends Action
{
    public function run()
    {
        echo 'hello world';
    }
}