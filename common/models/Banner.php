<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/10/19
 * Time: 下午6:33
 * Return:
 */

namespace common\models;

use yii\db\ActiveRecord;

class Banner extends ActiveRecord
{
    //平台ID
    const PLATFORM_WEB = 1;
    const PLATFORM_ANDROID = 2;
    const PLATFORM_IOS = 3;

    //运营位类型
    const TYPE_NORMAL_BANNER = 1;//普通文图类
    const TYPE_AD =2;//广告类
    const TYPE_INDEX_WORD_MESSAGE = 3;//首页滚动文字链消息

    //运营位状态
    const STATUS_SHOWING = 1;//投放中
    const STATUS_STOPPED = 2;//下架

    public static function tableName()
    {
        return '{{%banner}}';
    }

    /**
     * 返回所有符合条件记录
     * @param $condition
     * @return array|ActiveRecord[]
     */
    public function getListByCondition($condition)
    {
        $db = self::find();
        $db = $this->handlerCondition($db, $condition);

        return $db->asArray()->all();
    }

    public function handlerCondition($db, $condition)
    {
        if (!empty($condition) && is_array($condition)) {
            foreach ($condition as $k => $v) {
                if ($k == 'valid_date') {
                    $db = $db->andWhere("start_at<='{$v}'");
                    $db = $db->andWhere("end_at>='{$v}'");
                } else {
                    $db = $db->andWhere([$k => $v]);
                }
            }
        }

        return $db;
    }
}