<?php
use yii\helpers\Url;

$this->title = 'Jian Mo - 简默';
?>

<video class="video-player" preload="auto" autoplay="autoplay" loop="loop" data-height="1080" data-width="1920" height="1080" width="1920">
    <source src="<?=Url::to('@web/video/login.mp4') ?>" type="video/mp4">
    <!-- 此视频文件为支付宝所有，在此仅供样式参考，如用到商业用途，请自行更换为其他视频或图片，否则造成的任何问题使用者本人承担，谢谢 -->
</video>
<div class="video_mask"></div>
<div class="login">
    <h1>简默无声后台登录</h1>
    <form class="layui-form">
        <div class="layui-form-item">
            <input class="layui-input" name="username" placeholder="用户名" lay-verify="required" type="text" autocomplete="off">
        </div>
        <div class="layui-form-item">
            <input class="layui-input" name="password" placeholder="密码" lay-verify="required" type="password" autocomplete="off">
        </div>
        <div class="layui-form-item form_code">
            <input class="layui-input" name="code" placeholder="验证码" lay-verify="required" type="text" autocomplete="off">
            <div class="code"><img src="<?=Url::to('@web/img/code.jpg') ?>" width="116" height="36"></div>
        </div>
        <button class="layui-btn login_btn" lay-submit="" lay-filter="login">登录</button>
    </form>
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

        //登录按钮事件
        form.on("submit(login)",function(data){
            window.location.href = "<?=Url::to(['site/index']) ?>";
            return false;
        })
    })
</script>
