<?php
/**
 * Message:
 * User: jzc<jzc1@meitu.com>
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
        'home/style.css',
        'home/fontawesome-all.css'
    ];
    public $js = [
        'home/canva_moving_effect.js',
        'home/jquery-3.3.1.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}