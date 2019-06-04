<?php
/**
 * Message: 前台展示效果资源
 * User: jzc
 * Date: 2018/8/25
 * Time: 下午6:35
 * Return:
 */

namespace frontend\assets;

use yii\web\AssetBundle;

class IndexAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'http://data.jianmo.top/css/know_you/style.css',
        'http://data.jianmo.top/css/bootstrap.min.css',
        'http://data.jianmo.top/css/know_you/classy-nav.css',
        'http://data.jianmo.top/css/know_you/owl.carousel.css',
    ];

    public $js = [
        'http://data.jianmo.top/js/jquery/jquery-2.2.4.min.js',
        'http://data.jianmo.top/js/popper.min.js',
        'http://data.jianmo.top/js/bootstrap.min.js',
        'http://data.jianmo.top/js/plugins.js',
        'http://data.jianmo.top/js/know_you/active.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}