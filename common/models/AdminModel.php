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

    const ADMIN_USER_SESSION_KEY = 'ADMIN_USER_ID';

    const ADMIN_STATUS_NORMAL = 1;
    const ADMIN_STATUS_DELETED = 2;

    public function rules()
    {
        return [
            ['uid', 'string'],
            ['password', 'string'],
            ['verifyCode', 'captcha', 'captchaAction' => 'login/captcha', 'message' => '验证码错误'],
        ];
    }

    public function getOneByCondition($condition)
    {
        return (new UserAdmin())->getOneByCondition($condition);
    }

    /**
     * 登录 - 状态判断
     * 成功后设置session并更新用户信息
     * @return bool
     */
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

        if (empty($userInfo['status']) || $userInfo['status'] == self::ADMIN_STATUS_DELETED) {
            Yii::$app->session->setFlash('error', '账号异常,请联系管理员');
            return false;
        }

        Yii::$app->session->set(self::ADMIN_USER_SESSION_KEY, $userInfo['admin_id']);
        $this->updateInfo(['last_login_time' => NOW_DATE, 'last_login_ip' => getIP()], $condition);

        return true;
    }

    public function insertInfo($data)
    {
        return (new AdminModel())->insertInfo($data);
    }

    public function updateInfo($data, $condition)
    {
        return (new UserAdmin())->updateInfo($data, $condition);
    }
}