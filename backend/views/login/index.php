<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\captcha\Captcha;

$this->title = 'Jian Mo - 简默';
?>

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
<script src="<?=Url::to('@web/layui/layui.js') ?>"></script>
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

    function checkform() {
        $passwd = document.getElementById('password');
        var base = new Base64();
        $passwd.value = base.encode($passwd.value);
        return true;
    }

    function Base64() {

        // private property
        _keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";

        // public method for encoding
        this.encode = function (input) {
            var output = "";
            var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
            var i = 0;
            input = _utf8_encode(input);
            while (i < input.length) {
                chr1 = input.charCodeAt(i++);
                chr2 = input.charCodeAt(i++);
                chr3 = input.charCodeAt(i++);
                enc1 = chr1 >> 2;
                enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
                enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
                enc4 = chr3 & 63;
                if (isNaN(chr2)) {
                    enc3 = enc4 = 64;
                } else if (isNaN(chr3)) {
                    enc4 = 64;
                }
                output = output +
                    _keyStr.charAt(enc1) + _keyStr.charAt(enc2) +
                    _keyStr.charAt(enc3) + _keyStr.charAt(enc4);
            }
            return output;
        }

        // public method for decoding
        this.decode = function (input) {
            var output = "";
            var chr1, chr2, chr3;
            var enc1, enc2, enc3, enc4;
            var i = 0;
            input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
            while (i < input.length) {
                enc1 = _keyStr.indexOf(input.charAt(i++));
                enc2 = _keyStr.indexOf(input.charAt(i++));
                enc3 = _keyStr.indexOf(input.charAt(i++));
                enc4 = _keyStr.indexOf(input.charAt(i++));
                chr1 = (enc1 << 2) | (enc2 >> 4);
                chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
                chr3 = ((enc3 & 3) << 6) | enc4;
                output = output + String.fromCharCode(chr1);
                if (enc3 != 64) {
                    output = output + String.fromCharCode(chr2);
                }
                if (enc4 != 64) {
                    output = output + String.fromCharCode(chr3);
                }
            }
            output = _utf8_decode(output);
            return output;
        }

        // private method for UTF-8 encoding
        _utf8_encode = function (string) {
            string = string.replace(/\r\n/g,"\n");
            var utftext = "";
            for (var n = 0; n < string.length; n++) {
                var c = string.charCodeAt(n);
                if (c < 128) {
                    utftext += String.fromCharCode(c);
                } else if((c > 127) && (c < 2048)) {
                    utftext += String.fromCharCode((c >> 6) | 192);
                    utftext += String.fromCharCode((c & 63) | 128);
                } else {
                    utftext += String.fromCharCode((c >> 12) | 224);
                    utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                    utftext += String.fromCharCode((c & 63) | 128);
                }

            }
            return utftext;
        }

        // private method for UTF-8 decoding
        _utf8_decode = function (utftext) {
            var string = "";
            var i = 0;
            var c = c1 = c2 = 0;
            while ( i < utftext.length ) {
                c = utftext.charCodeAt(i);
                if (c < 128) {
                    string += String.fromCharCode(c);
                    i++;
                } else if((c > 191) && (c < 224)) {
                    c2 = utftext.charCodeAt(i+1);
                    string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                    i += 2;
                } else {
                    c2 = utftext.charCodeAt(i+1);
                    c3 = utftext.charCodeAt(i+2);
                    string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                    i += 3;
                }
            }
            return string;
        }
    }
</script>
