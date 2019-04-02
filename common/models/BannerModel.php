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
use Yii;

class BannerModel extends Model
{
    //平台ID
    const PLATFORM_WEB = 1;//网站
    const PLATFORM_ANDROID = 2;//安卓
    const PLATFORM_IOS = 3;//iOS
    public $platformMap = [
        self::PLATFORM_WEB => '网站',
        self::PLATFORM_ANDROID => '安卓',
        self::PLATFORM_IOS => '苹果'
    ];

    //运营位类型
    const TYPE_NORMAL_BANNER       = 1;//普通文图类
    const TYPE_AD                  = 2;//广告类
    const TYPE_INDEX_WORD_MESSAGE  = 3;//首页滚动文字链消息
    const TYPE_INDEX_ROLL_IMAGE    = 4;//首页滚动大图
    const TYPE_FOOTER_ROLL_IMAGE   = 5;//底部滚动图片
    const TYPE_INDEX_TOP_IMAGE     = 6;//首页顶部头图

    public $bannerTypeMap = [
        self::TYPE_NORMAL_BANNER => '普通图文类',
        self::TYPE_AD => '广告',
        self::TYPE_INDEX_WORD_MESSAGE => '首页滚动文字链消息',
        self::TYPE_INDEX_ROLL_IMAGE => '首页滚动大图',
        self::TYPE_FOOTER_ROLL_IMAGE => '底部滚动图片',
        self::TYPE_INDEX_TOP_IMAGE  => '首页顶部头图'
    ];

    //运营位状态
    const STATUS_SHOWING = 1;//投放中
    const STATUS_STOPPED = 2;//下架
    const STATUS_DELETED = 3;//已删除,不再展示

    public $bannerStatusMap = [
        self::STATUS_SHOWING => '投放中',
        self::STATUS_STOPPED => '下架中'
    ];

    public function getListByCondition($condition, $limit = 100, $offset = 0, $orderBy = 'created_at desc')
    {
        $banner = new Banner();
        $list = $banner->getListByCondition($condition, $limit, $offset, $orderBy);
        if (!empty($list)) {
            foreach ($list as $k => $v) {
                $list[$k]['platform_msg'] = $this->platformMap[$v['platform_id']];
                $list[$k]['status_msg'] = $this->bannerStatusMap[$v['status']];
                $list[$k]['type_msg'] = $this->bannerTypeMap[$v['type']];
            }
        }

        return $list;
    }

    public function getCountByCondition($condition)
    {
        return (new Banner())->getCountByCondition($condition);
    }

    public function getOneByCondition($condition)
    {
        return (new Banner())->getOneByCondition($condition);
    }

    public function insert($data)
    {
        $rs = (new Banner())->insertData($data);
        if (!$rs) {
            Yii::warning("insert data to banner failed;data:".json_encode($data), CATEGORIES_ERROR);
        }

        return $rs;
    }

    public function update($data, $condition)
    {
        foreach ($data as $k => $v) {
            if (empty($v)) {
                unset($data[$k]);
            }
        }

        $rs = (new Banner())->updateData($data, $condition);
        if (!$rs) {
            Yii::warning("update data to banner failed;data:".json_encode($data), CATEGORIES_ERROR);
        }

        return $rs;
    }
}