<?php
/**
 * Message: 用户Redis
 * User: jzc
 * Date: 2019/6/3
 * Time: 5:09 PM
 * Return:
 */

namespace common\cache\User;


use common\cache\BaseCache;

class UserRedis extends BaseCache
{
    protected $useRedis = true;

    const REDIS_BASE_UID = 'base_uid:';//用户基础ID
    const REDIS_USER_TOTAL = 'user_total:';//总用户数

    /** 用户基础ID */
    public function incrBaseUid()
    {
        if (!$this->cache->exists(self::REDIS_BASE_UID)) {
            $this->set(self::REDIS_BASE_UID, 10000000);
        }

        return intval($this->cache->incr(self::REDIS_BASE_UID));
    }

    public function setBaseUid($value)
    {
        return $this->set(self::REDIS_BASE_UID, $value);
    }

    /** 总用户数 */
    public function incrUserTotal()
    {
        return $this->cache->incr(self::REDIS_USER_TOTAL);
    }

    public function getUserTotal()
    {
        return $this->cache->get(self::REDIS_USER_TOTAL);
    }

    public function setUserTotal($value)
    {
        return $this->cache->set(self::REDIS_USER_TOTAL, $value);
    }
}