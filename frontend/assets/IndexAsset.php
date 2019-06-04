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
        'css/style.css',
        //'css/animate.css',
        'css/bootstrap.min.css',
        'css/classy-nav.css',
        'css/font-awesome.min.css',
        'css/owl.carousel.css',
    ];

    public $js = [
        'js/jquery/jquery-2.2.4.min.js',
        'js/popper.min.js',
        'js/bootstrap.min.js',
        'js/plugins.js',
        'js/active.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}