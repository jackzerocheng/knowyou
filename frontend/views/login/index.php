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
    function checkForm() {
        var passwd = document.getElementById('passwd');
        var base = new Base64();
        passwd.value = base.encode(passwd.value);
        return true;
    }

    function Base64() {

        // private property
        var _keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";

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


