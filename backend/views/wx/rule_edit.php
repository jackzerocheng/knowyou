<?php
use yii\helpers\Url;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>编辑规则</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" href="<?=Url::to('@web/img/favicon.ico') ?>">
    <link rel="stylesheet" href="<?=Url::to('@web/layui/css/layui.css') ?>" media="all" />
</head>
<body class="childrenBody">
<form class="layui-form" method="post" action="<?=Url::to(['wx-rules/update']) ?>">
    <input type="hidden" name="id" value="<?=$data['id'] ?>">
    <div class="layui-form-item">
        <label class="layui-form-label">关键词</label>
        <div class="layui-input-block">
            <input type="text" name="key_word" class="layui-input" lay-verify="required" value="<?=$data['key_word']?:'' ?>" disabled>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">目标词</label>
        <div class="layui-input-block">
            <input type="text" name="to_word" class="layui-input" lay-verify="required" value="<?=$data['to_word']?:'' ?>" placeholder="请输入目标词">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">规则类型</label>
        <div class="layui-input-block">
            <?php
            if (!empty($type_map)) {
                foreach ($type_map as $k => $v) {
                    if ($k == $data['type']) {
                        echo "<input type='radio' name='type' value='{$k}' title='{$v}' checked>";
                    } else {
                        echo "<input type='radio' name='type' value='{$k}' title='{$v}'>";
                    }
                }
            }
            ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">规则状态</label>
        <div class="layui-input-block">
            <?php
            if (!empty($status_map)) {
                foreach ($status_map as $k => $v) {
                    if ($k == $data['status']) {
                        echo "<input type='radio' name='status' value='{$k}' title='{$v}' checked>";
                    } else {
                        echo "<input type='radio' name='status' value='{$k}' title='{$v}'>";
                    }
                }
            }
            ?>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <p style="color:red"><?=Yii::$app->session->getFlash('edit_rule_message') ?></p>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="addNews">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>
<script type="text/javascript" src="<?=Url::to('@web/layui/layui.js') ?>"></script>
<script type="text/javascript" src="<?=Url::to('@web/js/backend.js') ?>"></script>
</body>
</html>