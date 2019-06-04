<?php
/**
 * Message: 缓存基类
 * User: jzc
 * Date: 2019/5/28
 * Time: 9:23 PM
 * Return:
 */

namespace common\cache;


class BaseCache
{
    protected $cache;
    protected $useRedis = false;

    public function __construct()
    {
        if ($this->useRedis) {
            $this->cache = \Yii::$app->redis;
        } else {
            $this->cache = \Yii::$app->cache;
        }
    }

    public function get($key)
    {
        return $this->cache->get($key);
    }

    /**
     * @param $key
     * @param $value
     * @param null $duration 持续时间，以秒计，0永久
     * @return bool
     */
    public function set($key, $value, $duration = null)
    {
        if ($this->useRedis) {
            if (!empty($duration)) {
                return $this->cache->setex($key, $duration, $value);
            }

            return $this->cache->set($key, $value);
        }

        return $this->cache->set($key, $value, $duration);
    }

    public function del($key)
    {
        return $this->cache->delete($key);
    }
}