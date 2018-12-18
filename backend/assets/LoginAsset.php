<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/layui.css',
        'css/login.css',
    ];
    public $js = [

    ];
    public $depends = [
        //'yii\bootstrap\BootstrapAsset',
    ];
}
