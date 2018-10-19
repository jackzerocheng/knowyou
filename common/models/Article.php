<?php
/**
 * Message: 文章Model
 * User: jzc
 * Date: 2018/10/18
 * Time: 下午6:37
 * Return:
 */

namespace common\models;

use yii\db\ActiveRecord;

class Article extends ActiveRecord
{
    const TABLE_PARTITION = 4;
    protected static $tableName = '';


    public function __construct($uid = 0, array $config = [])
    {
        parent::__construct($config);
        static::$tableName = '{{%article0' . $uid % self::TABLE_PARTITION . '}}';
    }

    public static function tableName()
    {
        return static::$tableName;
    }

    public function rules()
    {
        return [
            ['title', 'string', 'min' => 6, 'skipOnEmpty' => false]
        ];
    }

    public function getListByCondition($condition)
    {
        return self::find()->from(static::$tableName)->where($condition)->asArray()->all();
    }
}