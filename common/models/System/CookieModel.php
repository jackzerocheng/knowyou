<?php
/**
 * Message: cookie管理model
 * User: jzc
 * Date: 2019/6/3
 * Time: 3:45 PM
 * Return:
 */

namespace common\models\System;

use yii\web\Cookie;
use yii\base\Model;

class CookieModel extends Model
{
    private $cookie;

    const COOKIE_USER_INFO = 'user_info:';

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->cookie = \Yii::$app->request->cookies;
    }

    public function getUserInfoCookie()
    {
        $userInfo = [];
        if ($this->cookie->has(self::COOKIE_USER_INFO)) {
            $userInfo = $this->cookie->getValue(self::COOKIE_USER_INFO);
        }

        return $userInfo;
    }

    public function createUserInfoCookie($userInfo)
    {
        $cookie = new Cookie();
        $cookie->name = self::COOKIE_USER_INFO;
        $cookie->value = [
            'uid' => $userInfo['uid'],
            'password' => $userInfo['password'],
            'status' => $userInfo['status'],
        ];
        $cookie->expire = time() + ONE_WEEK;
        $cookie->httpOnly = true;

        \Yii::$app->response->cookies->add($cookie);
        return true;
    }

    public function removeUserInfoCookie()
    {
        if ($this->cookie->has(self::COOKIE_USER_INFO)) {
            $this->cookie->remove($this->cookie->get(self::COOKIE_USER_INFO));
        }

        return true;
    }
}