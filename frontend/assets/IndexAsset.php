<?php
/**
 * Message:
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
        'css/animate.css',
        'css/bootstrap.min.css',
        'css/classy-nav.css',
        'css/font-awesome.min.css',
        'css/owl.carousel.css',
    ];
    public $js = [
        'js/active.js',
        'js/bootstrap.min.js',
        'js/map-active.js',
        'js/plugins.js',
        'js/popper.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}