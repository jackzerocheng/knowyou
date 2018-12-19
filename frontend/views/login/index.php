<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\captcha\Captcha;

    $this->title = "简 · 默";
?>
<div id="bg">
    <canvas width="1920" height="938"></canvas>
    <canvas width="1920" height="938"></canvas>
    <canvas width="1920" height="938"></canvas>
</div>
<!-- //bg effect -->
<!-- title -->
<h1>简 · 默</h1>
<!-- //title -->
<!-- content -->
<div class="sub-main-w3">
    <?=Html::beginForm(['index'], 'post', ['id' => 'loginForm', 'onsubmit' => 'return checkForm()']) ?>
        <h2>
            马上登录
        </h2>
        <div class="form-style-agile">
            <div><?=Html::label('账号:', 'uid')?></div>
            <?=Html::activeInput('text', $model, 'uid', ['required' => '']) ?>
            <?=Html::error($model, 'uid', ['style' => 'color:red']); ?>
        </div>
        <div class="form-style-agile">
            <div><?=Html::label('密码:', 'password')?></div>
            <?=Html::activeInput('password', $model, 'password', ['required' => '', 'id' => 'passwd']) ?>
            <?=Html::error($model, 'password', ['style' => 'color:red']); ?>
        </div>
    <div class="form-verify-code">
        <div><?=Html::label('验证码:', 'verify_code')?></div>
        <?=Captcha::widget([
            'model' => $model,
            'attribute' => 'verifyCode',
            'template' => '{input}{image}',
            'captchaAction' => 'login/captcha',
            'options' => [
                'class' => '',
                'id' => 'verifyCode',
                'style' => 'vertical-align:middle;'
            ],
            'imageOptions' => [
                'class' => '',
                'id' => 'verifyCode-image',
                'style' => 'vertical-align:middle;'
            ],
        ]) ?>
        <?=Html::error($model, 'verifyCode', ['style' => 'color:red']); ?>
    </div>
        <div class="form-style-agile">
            <p style="text-align: center;color: red"><?=Yii::$app->session->getFlash('failed') ?></p>
        </div>
    <div class="form-style-agile">
        <p style="text-align: center;color: red"><?=Yii::$app->session->getFlash('success') ?></p>
    </div>
        <div class="wthree-text">
            <ul>
                <li>
                    <label class="anim">
                        <?=Html::label('保持登录', 'remember') ?>
                        <?=Html::activeInput('checkbox', $model, 'remember', ['value' => 1, 'checked' => true]) ?>
                    </label>
                </li>

                <li>
                    <a href="<?=Url::to(['login/register']) ?>">没有账号?</a><br>
                    <a href="#">忘记密码?</a>
                </li>
            </ul>
        </div>
        <input type="submit" value="登录">
    <?=Html::endForm(); ?>
</div>
<!-- //content -->
<script>
    //嘘，这个秘密被你发现了
    function checkForm() {
        var passwd = document.getElementById('passwd');
        passwd.value = window.btoa(passwd.value);
        return true;
    }
</script>


