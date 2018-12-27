<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'layui/css/layui.css',
        'css/font_tnyc.css',
        'css/main.css',
        'css/images.css',
        'css/message.css',
        'css/news.css',
        'css/user.css'
    ];
    public $js = [
        'layui/layui.js',
        'js/backend.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
