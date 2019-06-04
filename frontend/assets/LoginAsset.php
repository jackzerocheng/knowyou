<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/9/7
 * Time: 下午5:52
 * Return:
 */

namespace frontend\assets;

use yii\web\AssetBundle;

class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'http://data.jianmo.top/css/login_form_1/style.css',
        'http://data.jianmo.top/css/login_form_1/fontawesome-all.css'
    ];

    public $js = [
        'http://data.jianmo.top/js/canva_moving_effect.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}