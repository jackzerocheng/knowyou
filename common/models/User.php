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
    public static function tableName()
    {
        return '{{%user}}';
    }

    public function rules()
    {
        return [];
    }
}