<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>出错了</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
</head>
<body class="childrenBody">
<div style="text-align: center; padding:11% 0;">
    <img src="http://data.jianmo.top/img/default/not_found.gif">
    <p>系统遭受不明生物入侵！</p>
    <p style="font-size: 20px; font-weight: 300; color: #999;">
        <?= Yii::$app->session->getFlash('frontend_error_message') ?>
    </p>
</div>
</body>
</html>