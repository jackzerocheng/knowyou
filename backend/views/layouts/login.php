<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\LoginAsset;
use yii\helpers\Html;
use yii\helpers\Url;

LoginAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="format-detection" content="telephone=no">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <link rel="icon" href="<?=Url::to('@web/img/favicon.ico') ?>">
        <?php $this->head() ?>
    </head>
    <body>
            <?php $this->beginBody() ?>

            <?= $content ?>


            <div style="height: 30px;background-color: #f5f5f5;border-top: 1px solid #ddd;padding-top: 20px;">
                <p style="text-align: center">Copyright © <script>document.write(new Date().getFullYear());</script>.JZC All rights reserved.</p>
            </div>

            <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>