<?php
/**
 * Message: 用户Model
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

    const TABLE_PARTITION = 4;//分表数

    public $password_again;
    public static $uid;
    protected static $tableName = '';

    public function __construct($uid = 0, array $config = [])
    {
        parent::__construct($config);
        static::$tableName = static::getTableName($uid);
    }

    public static function tableName()
    {
        return static::$tableName;
    }

    private static function getTableName($uid = 0)
    {
        $uid = $uid ? : static::getUid();
        return '{{%user0' . $uid % self::TABLE_PARTITION . '}}';
    }

    /**
     * 依赖Redis返回生成的UID
     * @return int
     */
    private static function getUid()
    {
        $redis = Yii::$app->redis;
        static::$uid = $redis->incr(self::BASE_USER_ID);
        return static::$uid;
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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (empty($this->password)) {
                unset($this->password);
            } else {
                $this->password = setPassword($this->password);
            }

            return true;
        }

        return false;
    }
}