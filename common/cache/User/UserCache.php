<?php
/**
 * Message: 用户cache
 * User: jzc
 * Date: 2019/6/3
 * Time: 11:31 AM
 * Return:
 */

namespace common\cache\User;


use common\cache\BaseCache;

class UserCache extends BaseCache
{
    const CACHE_USER_INFO = 'user_info:';

    public function getUserInfo($uid)
    {
        $rs = [];

        $data = $this->get(self::CACHE_USER_INFO . $uid);
        if (!empty($data)) {
            $rs = json_decode($data, true);
        }

        return $rs;
    }

    public function setUserInfo($uid, $value)
    {
        return $this->set(self::CACHE_USER_INFO . $uid, $value, ONE_MONTH);
    }
}