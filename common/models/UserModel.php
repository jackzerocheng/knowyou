<?php
namespace common\models;

use common\cache\User\UserCache;
use common\cache\User\UserRedis;
use common\lib\Config;
use common\lib\CryptAes;
use common\models\System\CookieModel;
use common\models\System\SessionModel;
use Yii;
use yii\base\Model;
use common\dao\User;
use common\lib\CryptRsa;

class UserModel extends Model
{
    //表单所需
    public $uid;
    public $username;
    public $password;
    public $verifyCode;
    public $password_again;
    public $remember;

    const DEFAULT_HEAD_IMG = 'http://data.jianmo.top/img/default/default_head.png';

    //用户状态
    const STATUS_NORMAL = 1;
    const STATUS_STOP = 2;
    const STATUS_DELETED = 3;
    public $statusMap = [
        self::STATUS_NORMAL => '正常',
        self::STATUS_STOP => '封禁',
        self::STATUS_DELETED => '删除'
    ];

    private $cache;
    private $redis;

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->cache = new UserCache();
        $this->redis = new UserRedis();
    }

    public function rules()
    {
        return [
            ['uid', 'string', 'skipOnEmpty' => false],
            ['verifyCode', 'captcha', 'captchaAction' => 'login/captcha', 'message' => '验证码错误'],
            [['password', 'remember'], 'safe']
        ];
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

    public function login($uid, $password, $createCookie = false)
    {
        $userInfo = $this->getOneByCondition($uid, ['uid'=>$uid,'password'=>$password]);
        if (empty($userInfo)) {
            return false;
        }

        //创建session
        (new SessionModel())->createUidSession($uid);

        if ($createCookie) {
            (new CookieModel())->createUserInfoCookie($userInfo);
        }

        return $uid;
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
     * 注销登录
     * @return bool
     */
    public function logout()
    {
        (new SessionModel())->removeUidSession();
        (new CookieModel())->removeUserInfoCookie();

        return true;
    }

    public function getUserTotal($sync = false)
    {
        $userTotal = $this->redis->getUserTotal();

        if (empty($userTotal) || $sync) {
            $tmp = $this->getAllCountByCondition([]);
            if ($userTotal != $tmp) {
                $this->redis->setUserTotal($tmp);
            }

            $userTotal = $tmp;
        }

        return $userTotal;
    }

    /**
     * 注册用户，返回用户账号
     * @param $data
     * @return mixed
     */
    public function register(array $data)
    {
        //默认头像
        $data['head'] = empty($data['head']) ? self::DEFAULT_HEAD_IMG : $data['head'];
        //uid获取
        $uid = $this->redis->incrBaseUid();

        if (!empty($this->getUserInfo($uid))) {//异常情况下，如Redis数据被清空，需要依赖DB生成
            $uid = $this->getMaxUid() + 1;
            $this->redis->setBaseUid($uid);
        }

        $data['uid'] = $uid;
        $user = new User($data['uid']);
        if (!$user->insert(false, $data)) {
            Yii::warning('insert user info failed;info:'.json_encode($data), CATEGORIES_WARN);
            return false;
        }

        $this->redis->incrUserTotal();//总用户数

        Yii::info('user register;info:'.json_encode($data), CATEGORIES_INFO);
        return $data['uid'];
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

    /**
     * 根据UID获取用户信息
     * @param $uid
     * @return array|mixed
     */
    public function getUserInfo($uid)
    {
        $userInfo = $this->cache->getUserInfo($uid);

        if (empty($userInfo)) {
            $userInfo = $this->getOneByCondition($uid, ['uid' => $uid]);

            if (!empty($userInfo)) {
                $userInfo['article_number'] = (new ArticleModel())->getCountByCondition(['uid' => $userInfo['uid'], 'status'=> ArticleModel::ARTICLE_STATUS_NORMAL]);

                $this->cache->setUserInfo($uid, json_encode($userInfo));
            }
        }

        return $userInfo;
    }

    public function getMaxUid()
    {
        $maxId = 0;
        $count = USER::TABLE_PARTITION - 1;
        while ($count >= 0) {
            $tmp = (new User($count))->getMaxUid();
            $maxId = $tmp > $maxId ? $tmp : $maxId;
            $count--;
        }

        return $maxId;
    }
}
