<?php
/**
 * Message: session管理model
 * User: jzc
 * Date: 2019/6/3
 * Time: 3:39 PM
 * Return:
 */

namespace common\models\System;

use yii\base\Model;

class SessionModel extends Model
{
    private $session;

    const SESSION_USER_ID = 'user_id:';

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->session = \Yii::$app->session;
    }

    public function getUidSession()
    {
        $uid = $this->session->get(self::SESSION_USER_ID);

        return $uid;
    }

    public function createUidSession($uid)
    {
        $this->session->set(self::SESSION_USER_ID, $uid);
        return true;
    }

    public function removeUidSession()
    {
        $this->session->remove(self::SESSION_USER_ID);
        $this->session->destroy();
        return true;
    }
}