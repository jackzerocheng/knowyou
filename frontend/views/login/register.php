<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "懂你 -- 只为更好的你";
?>
<div id="bg">
    <canvas width="1920" height="938"></canvas>
    <canvas width="1920" height="938"></canvas>
    <canvas width="1920" height="938"></canvas>
</div>
<!-- //bg effect -->
<!-- title -->
<h1>懂你 - 只为更好的你</h1>
<!-- //title -->
<!-- content -->
<div class="sub-main-w3">
    <?=Html::beginForm(['login'], 'post', ['id' => 'loginForm']) ?>
    <h2>
        立即注册
    </h2>
    <div class="form-style-agile">
        <?=Html::label('用户名:', 'username')?>
        <?=Html::activeInput('text', $model, 'uid', ['required' => '']) ?>
        <?=Html::error($model, 'username', ['style' => 'color:red']); ?>
    </div>
    <div class="form-style-agile">
        <?=Html::label('密码:', 'password')?>
        <?=Html::activeInput('password', $model, 'password', ['required' => '']) ?>
        <?=Html::error($model, 'password', ['style' => 'color:red']); ?>
    </div>
    <div class="form-style-agile">
        <?=Html::label('再次输入:', 'password')?>
        <?=Html::activeInput('password', $model, 'password', ['required' => '']) ?>
        <?=Html::error($model, 'password', ['style' => 'color:red']); ?>
    </div>
    <div class="form-style-agile">
        <p style="text-align: center;color: red"><?=Yii::$app->session->getFlash('failed') ?></p>
    </div>
    <div class="wthree-text">
        <ul>
            <li>
                <label class="anim">
                    <a href="<?=Url::to(['index']) ?>">返回首页</a>
                </label>
            </li>
            <li>
                <a href="<?=Url::to(['reset_password']) ?>">忘记密码?</a>
            </li>
        </ul>
    </div>
    <input type="submit" value="注册">
    <?=Html::endForm(); ?>
</div>
<!-- //content -->

<!-- copyright -->
<div class="footer">
    <p>Copyright © 2018.JZC All rights reserved.</p>
</div>

