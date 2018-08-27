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
    <?=Html::beginForm('actionlogin', 'post', []) ?>
        <h2>
            马上登录
        </h2>
        <div class="form-style-agile">
            <?=Html::label('用户名:', 'username')?>
            <?=Html::activeInput('text', $model, 'username', ['required' => '']) ?>
            <?=Html::error($model, 'username', ['style' => 'color:red']); ?>
        </div>
        <div class="form-style-agile">
            <?=Html::label('密码:', 'password')?>
            <?=Html::activeInput('password', $model, 'password', ['required' => '']) ?>
            <?=Html::error($model, 'password', ['style' => 'color:red']); ?>
        </div>
        <!-- checkbox -->
        <div class="wthree-text">
            <ul>
                <li>
                    <label class="anim">
                        <input type="checkbox" class="checkbox" required="">
                        <span>记住我</span>
                    </label>
                </li>
                <li>
                    <a href="">忘记密码?</a>
                </li>
            </ul>
        </div>
        <!-- //checkbox -->
        <input type="submit" value="Log In">
    <?=Html::endForm(); ?>
</div>
<!-- //content -->

<!-- copyright -->
<div class="footer">
    <p>Copyright © 2018.JZC All rights reserved.</p>
</div>

