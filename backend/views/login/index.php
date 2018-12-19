<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\captcha\Captcha;

$this->title = 'Jian Mo - 简默';
?>

<video class="video-player" muted preload="auto" autoplay="autoplay" loop="loop" data-height="1080" data-width="1920" height="1080" width="1920">
    <source src="<?=Url::to('@web/video/login.mp4') ?>" type="video/mp4">
    <!-- 此视频文件为支付宝所有，在此仅供样式参考，如用到商业用途，请自行更换为其他视频或图片，否则造成的任何问题使用者本人承担，谢谢 -->
</video>
<div class="video_mask"></div>
<div class="login">
    <h1>简默无声后台登录</h1>
    <?=Html::beginForm(['index'], 'post', ['id' => 'loginForm', 'class' => 'layui-form', 'onsubmit' => 'return checkform()']) ?>
        <div class="layui-form-item">
            <?=Html::activeInput('text', $model, 'uid',
                ['class' => 'layui-input','placeholder' => '用户账号','lay-verify'=>'required','autocomplete'=>'off']) ?>
            <?=Html::error($model, 'uid', ['style' => 'color:red']) ?>
        </div>
        <div class="layui-form-item">
            <?=Html::activeInput('password', $model, 'password',
                ['class' => 'layui-input','placeholder' => '密码','lay-verify' => 'required','autocomplete'=>'off','id'=>'password']) ?>
            <?=Html::error($model, 'password', ['style' => 'color:red']) ?>
        </div>
        <div class="layui-form-item form_code">
            <?=Captcha::widget([
                    'model' => $model,
                    'attribute' => 'verifyCode',
                    'template' => '{input}<div class="code">{image}</div>',
                    'captchaAction' => 'login/captcha',
                    'options' => [
                        'class' => 'layui-input',
                        'id' => 'verifyCode',
                        'placeholder' => '验证码',
                        'lay-verify' => 'required',
                        'autocomplete'=>'off',
                        'style' => 'width:116;height:36'
                    ],
                    'imageOptions' => [
                        'class' => '',
                        'id' => 'verifyCode-image',
                        'width' => '116',
                        'height' => '36'
                    ],
                ]) ?>
            <?=Html::error($model, 'verifyCode', ['style' => 'color:red']) ?>
        </div>
        <input type="submit" class="layui-btn login_btn" lay-filter="login" value="登录">
    <div class="layui-form-item">
        <p style="text-align: center;color: red"><?=Yii::$app->session->getFlash('error') ?></p>
    </div>
    <?=Html::endForm(); ?>
</div>
<script src="<?=Url::to('@web/js/layui.js') ?>"></script>
<!-- 后者依赖前者 -->
<script>
    layui.config({
        base : "<?=Url::to('@web/js/') ?>"
    }).use(['form','layer'],function(){
        var form = layui.form(),
            layer = parent.layer === undefined ? layui.layer : parent.layer,
            $ = layui.jquery;
        //video背景
        $(window).resize(function(){
            if($(".video-player").width() > $(window).width()){
                console.log('1111');
                $(".video-player").css({"height":$(window).height(),"width":"auto","left":-($(".video-player").width()-$(window).width())/2});
            }else{
                console.log('2222');
                $(".video-player").css({"width":$(window).width(),"height":"auto","left":-($(".video-player").width()-$(window).width())/2});
            }
        }).resize();
    })

    //简单加密，被你发现了。。
    function checkform() {
        $passwd = document.getElementById('password');
        //var base = new Base64();
        $passwd.value = window.btoa($passwd.value);
        return true;

    }
</script>
