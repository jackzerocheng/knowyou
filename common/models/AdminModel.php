<?php
/**
 * Message: 管理员model
 * User: jzc
 * Date: 2018/10/22
 * Time: 10:23 AM
 * Return:
 */

namespace common\models;

use yii\base\Model;
use common\dao\UserAdmin;

class AdminModel extends Model
{
    public $username;
    public $password;
    public $verifyCode;

    public function rules()
    {
        return ['verifyCode', 'captcha', 'captchaAction' => 'login/captcha', 'message' => '验证码错误'];
    }

    public function getOneByCondition($condition)
    {
        return (new UserAdmin())->getOneByCondition($condition);
    }
}