<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/10/20
 * Time: 4:03 PM
 * Return:
 */

namespace common\dao;

use yii\db\ActiveRecord;

class UserAdmin extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%user_admin}}';
    }
}