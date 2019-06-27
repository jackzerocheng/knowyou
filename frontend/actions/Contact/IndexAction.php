<?php
/**
 * Message: 联系我们页
 * User: jzc
 * Date: 2019/6/27
 * Time: 10:30 AM
 * Return:
 */

namespace frontend\actions\Contact;

use frontend\actions\BaseAction;

class IndexAction extends BaseAction
{
    public function run()
    {
        return $this->controller->render('index');
    }
}