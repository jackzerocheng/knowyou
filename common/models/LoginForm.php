<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\Cookie;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $uid;
    public $password;
    public $verifyCode;
    public $remember;

    private $user;

    //本地状态直接先获取session，来判断是否已登录
    const SESSION_USE_ID = 'SESSION_USER_ID';
    //不存在session则去拿cookie
    const COOKIE_USER_INFO = 'COOKIE_USER_INFO';
    //多端登录时去Redis判断，是否在其他端已登录
    const REDIS_USERNAME = 'user_name';
    const REDIS_STATUS = 'status';
    const REDIS_IP = 'ip';
    const REDIS_LOGIN_TIME = 'login_time';
    //保持登录时长
    const REDIS_KEEP_TIME = 60 * 60 * 24;//一天
    const COOKIE_KEEP_TIME = 60 * 60 * 24 * 7;//七天

    public function rules()
    {
        return [
            ['uid', 'validateAccount', 'skipOnEmpty' => false],
            ['verifyCode', 'captcha', 'captchaAction' => 'login/captcha', 'message' => '验证码错误'],
            [['password', 'remember'], 'safe']
        ];
    }

    public function validateAccount($attribute, $params)
    {
        if (!preg_match('/^\w{2,30}$/', $this->$attribute)) {
            $this->addError($attribute, '账号或密码错误');
        } elseif(strlen($this->password) < 6) {
            $this->addError($attribute, '密码长度不正确');
        } else {
            $user = User::find()->from(User::tableName($this->uid))->where(['uid' => $this->$attribute])->asArray()->one();
            if (!$user || $user['password'] != setPassword($this->password)) {
                $this->addError($attribute, '账号或密码错误');
            } else {
                $this->user = $user;
            }
        }
    }

    public function login()
    {
        if (!$this->user) {
            return false;
        }

        $this->createSession();

        if ($this->remember) {
            $this->createCookie();
        }

        return true;
    }

    /**
     * 生成session登录态
     * 本地一份，Redis一份
     *
     */
    public function createSession()
    {
        Yii::$app->session->set(self::SESSION_USE_ID, $this->uid);

        $redis = Yii::$app->redis;
        $redis->hset($this->uid, self::REDIS_USERNAME, $this->user['username']);
        $redis->hset($this->uid, self::REDIS_STATUS, $this->user['status']);
        $redis->hset($this->uid, self::REDIS_IP, getIP());
        $redis->hset($this->uid, self::REDIS_LOGIN_TIME, NOW_DATE);
        $redis->expire($this->uid, self::REDIS_KEEP_TIME);
    }

    public function createCookie()
    {
        $cookie = new Cookie();
        $cookie->name = self::COOKIE_USER_INFO;
        $cookie->value = [
            'uid' => $this->user['uid'],
            'username' => $this->user['username'],
            'status' => $this->user['status'],
        ];
        $cookie->expire = time() + self::COOKIE_KEEP_TIME;
        $cookie->httpOnly = true;

        Yii::$app->response->cookies->add($cookie);
    }

    public function loginByCookie()
    {
        $cookie = Yii::$app->response->cookies;
        if ($cookie->has(self::COOKIE_USER_INFO)) {
            $userInfo = $cookie->getValue(self::COOKIE_USER_INFO);
            if (isset($userInfo['uid']) && isset($userInfo['username'])) {
                $this->user = User::find()->where(['uid' => $userInfo['uid'], 'username' => $userInfo['username']])->asArray()->one();
                if ($this->user) {
                    $this->createSession();
                    return true;
                }
            }
        }

        return false;
    }

    public function logout()
    {
        Yii::$app->session->remove(self::SESSION_USE_ID);
        Yii::$app->session->destroy();

        Yii::$app->redis->del($this->user['uid']);

        $cookie = Yii::$app->response->cookies;
        if ($cookie->has(self::COOKIE_USER_INFO)) {
            $cookie->remove($cookie->get(self::COOKIE_USER_INFO));
        }

        return true;
    }
}
