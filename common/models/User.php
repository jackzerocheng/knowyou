<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/8/25
 * Time: 下午6:59
 * Return:
 */

namespace common\models;

use yii\db\ActiveRecord;
use Yii;

class User extends ActiveRecord
{
    const BASE_USER_ID = 'BASE_USER_ID';

    const STATUS_NORMAL = 1;
    const STATUS_STOP = 2;
    const STATUS_DELETED = 3;

    public $statusMap = [
        self::STATUS_NORMAL => '正常',
        self::STATUS_STOP => '封禁',
        self::STATUS_DELETED => '删除'
    ];

    public $password_again;

    public static function tableName($uid = 0)
    {
        $uid = $uid ? : self::getUid();
        return '{{%user0' . ($uid % 4) . '}}';
    }

    public static function getUid()
    {
        //取baseID直接通过incr来返回，利用原子操作应对高并发场景
        $redis = Yii::$app->redis;
        return $redis->incr(self::BASE_USER_ID);
    }
    /**
     * 参数校验
     * @return array
     */
    public function rules()
    {
        return [
            ['username', 'checkName', 'skipOnEmpty' => false],
            ['password', 'string', 'min' => 6, 'tooShort' => '密码长度不能小于6位', 'skipOnEmpty' => false],
            ['password_again', 'string']
        ];
    }

    public function checkName($attribute, $params)
    {
        if (strlen($this->username) < 1 || strlen($this->username) > 30) {
            $this->addError($attribute, '用户名格式长度为1-30');
        } elseif (self::find()->where(['username' => $this->username])->count() > 0) {
            $this->addError($attribute, '该用户名已存在');
        } elseif ($this->password != $this->password_again) {
            $this->addError($attribute, '两次输入密码不一致');
        }
    }
/*
    public function checkPhone($attribute)
    {
        if (!preg_match('/^((1[3,5,8][0-9])|(14[5,7])|(17[0,6,7,8])|(19[7]))\d{8}$/', $attribute)) {
            $this->addError($attribute, '手机号格式不正确');
        }
    }

    public function checkEmail($attribute)
    {
        if (!preg_match('/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/', $attribute)) {
            $this->addError($attribute, '邮箱格式不正确');
        }
    }
*/
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (empty($this->password)) {
                unset($this->password);
            } else {
                $this->password = setPassword($this->password);
                $this->uid = self::getUid();
            }

            return true;
        }

        return false;
    }
}