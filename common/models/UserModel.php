<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\Cookie;
use common\dao\User;

/**
 * Login form
 */
class UserModel extends Model
{
    public $uid;
    public $username;
    public $password;
    public $password_again;
    public $verifyCode;
    public $remember;

    private $user;

    //本地状态直接先获取session，来判断是否已登录
    const SESSION_USE_ID = 'SESSION_USER_ID';
    //不存在session则去拿cookie
    const COOKIE_USER_INFO = 'COOKIE_USER_INFO';
    //多端登录时去Redis判断，是否在其他端已登录
    const REDIS_KEY_PREFIX = 'know_you_web_';

    //保持登录时长
    const REDIS_KEEP_TIME = 60 * 60 * 24;//一天
    const COOKIE_KEEP_TIME = 60 * 60 * 24 * 7;//七天

    const STATUS_NORMAL = 1;
    const STATUS_STOP = 2;
    const STATUS_DELETED = 3;

    public $statusMap = [
        self::STATUS_NORMAL => '正常',
        self::STATUS_STOP => '封禁',
        self::STATUS_DELETED => '删除'
    ];

    public function rules()
    {
        return [
            ['uid', 'validateLogin', 'skipOnEmpty' => false],
            ['verifyCode', 'captcha', 'captchaAction' => 'login/captcha', 'message' => '验证码错误'],
            [['password', 'remember'], 'safe']
        ];
    }

    public function validateLogin($attribute, $params)
    {
        if (!preg_match('/^\w{2,30}$/', $this->$attribute)) {
            $this->addError($attribute, '账号长度不正确');
        } elseif(strlen($this->password) < 6) {
            $this->addError('password', '密码长度不正确');
        } elseif (!empty($this->uid)) {
            $userModel = new User($this->uid);
            $user = $userModel::find()->where(['uid' => $this->attributes])->asArray()->one();
            if (!$user) {
                $this->addError($attribute, '账号不存在');
            } elseif ($user['password'] != setPassword($this->password)) {
                $this->addError('password', '密码不正确');
            } elseif ($user['status'] != self::STATUS_NORMAL) {
                $this->addError($attribute, '账号状态异常');
            } else {
                $this->user = $user;
            }
        }
    }

    public function validateRegister($params)
    {
        if (strlen($params['username']) > 30) {
            $this->addError('username', '用户名不阔以超出30个字符');
            return false;
        } elseif (strlen($params['password']) < 6) {
            $this->addError('password', '密码至少要6位哦');
            return false;
        } elseif ($params['password'] != $params['password_again']) {
            $this->addError('password_again', '欧尼酱，你的两次密码不相同');
            return false;
        } elseif ($this->getCountByCondition(['username' => $params['username']]) > 0) {
            $this->addError('username', '哎呀客官，这个用户名已经有人使用了哦~~');
            return false;
        }

        return true;
    }

    /**
     * 先判断rule是否通过
     * 创建session和cookie
     * @return bool
     */
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

    public function loginByRequest($uid, $password, $platformID)
    {
        if (!in_array($platformID, [BannerModel::PLATFORM_ANDROID, BannerModel::PLATFORM_IOS])) {
            return false;
        }


    }

    /**
     * 生成session登录态
     * 本地一份，Redis一份
     * @return bool
     */
    public function createSession()
    {
        Yii::$app->session->set(self::SESSION_USE_ID, $this->uid);

        $redis = Yii::$app->redis;
        $redis->hset(self::REDIS_KEY_PREFIX . $this->uid, 'username', $this->user['username']);
        $redis->hset(self::REDIS_KEY_PREFIX . $this->uid, 'status', $this->user['status']);
        $redis->hset(self::REDIS_KEY_PREFIX . $this->uid, 'login_ip', getIP());
        $redis->hset(self::REDIS_KEY_PREFIX . $this->uid, 'login_time', NOW_DATE);
        $redis->expire(self::REDIS_KEY_PREFIX . $this->uid, self::REDIS_KEEP_TIME);

        return true;
    }

    /**
     * 创建cookie
     * @return bool
     */
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
        return true;
    }

    /**
     * 通过cookie登录
     * @return bool
     */
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

    /**
     * 注销登录，session + Redis
     * @return bool
     */
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

    /**
     * 获取用户session
     * @return bool|mixed
     */
    public function getSession()
    {
        $session = Yii::$app->session;
        $uid = $session->get(self::SESSION_USE_ID);
        if (empty($uid)) {
            return false;
        }

        return $uid;
    }

    /**
     * 获取用户Redis
     * @param $uid
     * @return array|bool
     */
    public function getRedis($uid)
    {
        $redis = Yii::$app->redis;
        $key = self::REDIS_KEY_PREFIX . $uid;
        if (!$redis->exists($key)) {
            return false;
        }

        $rs = [
            'uid' => $uid,
            'login_time' => $redis->hget($key, 'login_time'),
            'login_ip' => $redis->hget($key, 'login_ip')
        ];

        return $rs;
    }

    /**
     * 注册用户，返回用户账号
     * @param $data
     * @return mixed
     */
    public function register(array $data = null)
    {
        $user = new User();
        if (!$user->insert(false, $data)) {
            return false;
        }

        return $user::$uid;
    }

    /**
     * 对所有用户表检索，得到总数
     * 注意：UID不能传0，不然 0 == null 产生bug。。
     * @param $condition
     * @return int
     */
    public function getCountByCondition($condition = null)
    {
        $count = User::TABLE_PARTITION;
        $number = 0;
        while ($count - User::TABLE_PARTITION < User::TABLE_PARTITION) {
            $user = new User($count);
            $number += $user->getCountByCondition($condition);
            $count++;
        }

        return $number;
    }

    /**
     * 根据UID查找用户信息
     * @param $uid
     * @return mixed
     */
    public function getOneByUid($uid)
    {
        $user = new User($uid);
        return $user->getOneByCondition();
    }
}
