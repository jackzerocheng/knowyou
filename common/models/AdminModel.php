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
use common\lib\CryptAes;
use Yii;

class AdminModel extends Model
{
    public $uid;
    public $password;
    public $verifyCode;

    public function rules()
    {
        return [
            ['uid', 'required'],
            ['password', 'required'],
            ['verifyCode', 'captcha', 'captchaAction' => 'login/captcha', 'message' => '验证码错误'],
        ];
    }

    public function getOneByCondition($condition)
    {
        return (new UserAdmin())->getOneByCondition($condition);
    }

    public function login()
    {
        $this->password = base64_decode($this->password);//base64解码
        $condition = [
            'admin_id' => $this->uid,
            'password' => (new CryptAes(ADMIN_AES_KEY))->encrypt($this->password)
        ];
        $userInfo = (new UserAdmin())->getOneByCondition($condition);
        if (empty($userInfo)) {
            Yii::$app->session->setFlash('error', '登录失败');
            return false;
        }

        return true;
    }

    public function addAdmin()
    {

    }
}