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
    private $requestCookie;
    private $responseCookie;

    const COOKIE_USER_INFO = 'user_info:';

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->requestCookie = \Yii::$app->request->cookies;
        $this->responseCookie = \Yii::$app->response->cookies;
    }

    public function getUserInfoCookie()
    {
        $userInfo = [];
        if ($this->requestCookie->has(self::COOKIE_USER_INFO)) {
            $userInfo = $this->requestCookie->getValue(self::COOKIE_USER_INFO);
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

        $this->responseCookie->add($cookie);
        return true;
    }

    public function removeUserInfoCookie()
    {
        if ($this->requestCookie->has(self::COOKIE_USER_INFO)) {
            $this->responseCookie->remove(self::COOKIE_USER_INFO);
        }

        return true;
    }
}