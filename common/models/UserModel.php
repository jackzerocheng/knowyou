<?php
namespace common\models;

use common\lib\Config;
use common\lib\CryptAes;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\web\Cookie;
use common\dao\User;
use common\lib\CryptRsa;

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

    //自增生成UID
    const BASE_USER_ID_KEY = self::REDIS_KEY_PREFIX . 'BASE_USER_ID';
    //起始UID段
    const START_UID = 10000000;
    const DEFAULT_HEAD_IMG = 'http://data.jianmo.top/img/default/default_head.png';

    //保持登录时长
    const REDIS_KEEP_TIME = 60 * 60 * 24;//一天
    const COOKIE_KEEP_TIME = 60 * 60 * 24 * 7;//七天

    //用户状态
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
        //base64解密
        $this->password = base64_decode($this->password);

        if (!preg_match('/^\w{2,30}$/', $this->$attribute)) {
            $this->addError($attribute, '账号长度不正确');
        } elseif(strlen($this->password) < 6 || strlen($this->password) > 20) {
            $this->addError('password', '密码长度不正确');
        } elseif (!empty($this->uid)) {
            $userModel = new User($this->uid);
            $user = $userModel::find()->where(['uid' => $this->uid])->asArray()->one();
            if (!$user) {
                $this->addError($attribute, '账号不存在');
            } elseif ((new CryptAes(USER_AES_KEY))->encrypt($this->password) != $user['password']) {
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
        } elseif ($this->getAllCountByCondition(['username' => $params['username']]) > 0) {
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

        $this->createSession($this->user['uid']);

        if ($this->remember) {
            $this->createCookie();
        }

        return true;
    }

    /**
     * 第三方接入获取access_token
     * 有效时间默认七天
     * 目前仅限安卓和苹果
     * @param $uid
     * @param $password
     * @param $platformID
     * @param int $expire
     * @return bool|string
     */
    public function getAccessToken($uid, $password, $platformID, $expire = 604800)
    {
        if (!in_array($platformID, [BannerModel::PLATFORM_ANDROID, BannerModel::PLATFORM_IOS])) {
            return false;
        }

        $userInfo = $this->getOneByCondition($uid, ['password' => (new CryptAes())->encrypt($password)]);
        if (empty($userInfo)) {
            return false;
        }

        $data = [
            'uid' => $uid,
            'platform_id' => $platformID,
            'login_time' => time(),
            'expire_time' => time() + $expire
        ];
        $content = json_encode($data);

        return (new CryptRsa())->priEncrypt($content, Config::getPem('rsa_private_key'));
    }

    /**
     * 生成session登录态
     * 本地一份，Redis一份
     * @param  int $uid
     * @throws Exception
     * @return bool
     */
    public function createSession($uid)
    {
        try {
            Yii::$app->session->set(self::SESSION_USE_ID, $uid);

            $redis = Yii::$app->redis;
            $redis->hset(self::REDIS_KEY_PREFIX . $uid, 'login_ip', getIP());
            $redis->hset(self::REDIS_KEY_PREFIX . $uid, 'login_time', NOW_DATE);
            $redis->expire(self::REDIS_KEY_PREFIX . $uid, self::REDIS_KEEP_TIME);
        } catch (Exception $e) {
            Yii::error("create session failed;uid:{$uid};error:{$e}", CATEGORIES_ERROR);
            throw $e;
        }

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
            'password' => $this->user['password'],
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
        $cookie = Yii::$app->request->cookies;
        if ($cookie->has(self::COOKIE_USER_INFO)) {
            $userInfo = $cookie->getValue(self::COOKIE_USER_INFO);
            if (isset($userInfo['uid']) && isset($userInfo['password'])) {
                $this->user = (new User($userInfo['uid']))->getOneByCondition(['uid' => $userInfo['uid'], 'password' => $userInfo['password']]);
                if ($this->user) {
                    $this->createSession($this->user['uid']);
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
    public function register(array $data)
    {
        if (empty($data) || empty($data['password'])) {
            return false;
        }

        if (!empty($data['password'])) {
            $data['password'] = (new CryptAes(USER_AES_KEY))->encrypt($data['password']);
        }

        if (empty($data['head'])) {
            $data['head'] = self::DEFAULT_HEAD_IMG;
        }

        /*
         * 依赖Redis自增UID
         */
        $redis = Yii::$app->redis;
        if (!$redis->exists(self::BASE_USER_ID_KEY)) {
            $redis->set(self::BASE_USER_ID_KEY, self::START_UID);
        }
        $uid = $redis->incr(self::BASE_USER_ID_KEY);
        $data['uid'] = $uid;


        $user = new User($uid);
        $transaction = Yii::$app->db->beginTransaction();

        if (!$user->insert(false, $data)) {
            Yii::warning('insert user info failed;info:'.json_encode($data), CATEGORIES_WARN);
            $transaction->rollBack();
            return false;
        }

        if (!(new UserIndexModel())->insert($uid)) {
            Yii::warning('insert user index info failed;uid:'.$uid, CATEGORIES_WARN);
            $transaction->rollBack();
            return false;
        }

        $transaction->commit();
        Yii::info('user register;uid:'.$uid, CATEGORIES_INFO);
        return intval($uid);
    }

    /**
     * 对所有用户表检索，得到总数
     * 注意：UID不能传0，不然 0 == null 产生bug。。
     * @param $condition
     * @return int
     */
    public function getAllCountByCondition($condition = null)
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
     * @param $condition
     * @return mixed
     */
    public function getOneByCondition($uid, $condition)
    {
        $user = new User($uid);
        return $user->getOneByCondition($condition);
    }

    /**
     * 获取UID => 用户信息 映射
     * @param array $uid
     * @return array
     */
    public function getUserMap(array $uid)
    {
        if (empty($uid) || !is_array($uid)) {
            return [];
        }

        $group = array();
        foreach ($uid as $_uid) {
            $part = $_uid % User::TABLE_PARTITION;
            $group[$part] = array();
            if (!in_array($_uid, $group[$part])) {
                $group[$part][] = $_uid;
            }
        }

        $rs = array();
        foreach ($group as $k => $v) {
            $temp = (new User($k))->getListByCondition(['uid' => $v]);
            foreach ($temp as $_temp) {
                $rs[$_temp['uid']] = $temp[0];
            }
        }

        return $rs;
    }
}
