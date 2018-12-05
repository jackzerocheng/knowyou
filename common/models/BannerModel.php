<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/10/22
 * Time: 3:31 PM
 * Return:
 */

namespace common\models;

use yii\base\Model;
use common\dao\Banner;

class BannerModel extends Model
{
    //平台ID
    const PLATFORM_WEB = 1;
    const PLATFORM_ANDROID = 2;
    const PLATFORM_IOS = 3;

    //运营位类型
    const TYPE_NORMAL_BANNER = 1;//普通文图类
    const TYPE_AD =2;//广告类
    const TYPE_INDEX_WORD_MESSAGE = 3;//首页滚动文字链消息
    const TYPE_INDEX_ROLL_IMAGE = 4;//首页滚动大图
    const TYPE_FOOTER_ROLL_IMAGE = 5;//底部滚动图片

    public $bannerTypeMap = [
        self::TYPE_NORMAL_BANNER => '普通图文类',
        self::TYPE_AD => '广告',
        self::TYPE_INDEX_WORD_MESSAGE => '首页滚动文字链消息',
        self::TYPE_INDEX_ROLL_IMAGE => '首页滚动大图',
        self::TYPE_FOOTER_ROLL_IMAGE => '底部滚动图片'
    ];

    //运营位状态
    const STATUS_SHOWING = 1;//投放中
    const STATUS_STOPPED = 2;//下架

    public $bannerStatusMap = [
        self::STATUS_SHOWING => '投放中',
        self::STATUS_STOPPED => '下架'
    ];

    public function getListByCondition($condition, $limit = 100)
    {
        $banner = new Banner();
        return $banner->getListByCondition($condition, $limit);
    }
}