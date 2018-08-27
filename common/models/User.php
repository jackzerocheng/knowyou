<?php
/**
 * Message:
 * User: jzc<jzc1@meitu.com>
 * Date: 2018/8/25
 * Time: 下午6:59
 * Return:
 */

namespace common\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    protected static $uid;
    const STATUS_NORMAL = 1;
    const STATUS_STOP = 2;
    const STATUS_DELETED = 3;

    public $statusMap = [
        self::STATUS_NORMAL => '正常',
        self::STATUS_STOP => '封禁',
        self::STATUS_DELETED => '删除'
    ];

    function __construct($uid = null)
    {
        if ($uid) {
            self::$uid = $uid;
        } else {
            //   太粗糙，实际中用UUID或Redis比较合理
            self::$uid = time() . mt_rand(0,9);
        }

        parent::__construct();
    }

    public static function tableName()
    {
        return '{{%user' . self::getTable() . '}}';
    }

    private static function getTable()
    {
        return '0' . self::$uid % 4;
    }

    /**
     * 参数校验
     * @return array
     */
    public function rules()
    {
        return [
            ['username', 'checkName', 'max' => 30, 'tooLong' => '长度不能大于30', 'skipOnEmpty' => false],
            ['password', 'string', 'min' => 6, 'tooShort' => '密码长度不能小于6位', 'skipOnEmpty' => false],
            ['signature', 'string', 'max' => 50, 'tooLong' => '长度不能大于50', 'skipOnEmpty' => true],
            ['phone', 'checkPhone'],
            ['email', 'checkEmail'],
            ['status','in', 'range' => [1, 2, 3], 'message' => '非法操作']
        ];
    }

    public function checkName($attribute, $params)
    {
        if (self::find()->where(['username' => $this->attributes])->count() > 0) {
            $this->addError($attribute, '该用户名已存在');
        }
    }

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

}