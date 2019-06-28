<?php
use yii\helpers\Url;

$this->title = '联系我们';

?>
<link rel="stylesheet" href="http://data.jianmo.top/css/contact_form_1/style.css">
<link rel="stylesheet" href="http://data.jianmo.top/css/contact_form_1/style2.css">
<script href="http://data.jianmo.top/js/jquery/jquery-2.2.4.min.js"></script>

<div class="blog-wrapper section-padding-100 clearfix">
    <div class="container">
        <div class="row align-items-end">

            <div id="contact">

                <!-- Logo, title and informative content -->
                <div id="logo" class="bouncing">
                    <em class="icon-food"></em>
                </div>

                <h1 id="title"> 联系我们  </h1>
                <p id="pre">
                    如果你有更好的建议或其他想法，欢迎在下面填写
                </p>


                <!-- Form fields wrapper -->
                <div id="wrapper" class="clearfix">

                    <!-- Name -->
                    <input type="text" id="name" name="name" placeholder="姓名" required>


                    <!-- Email -->
                    <input type="email" id="email" name="email" placeholder="邮箱" required>


                    <!-- Contact -->
                    <textarea name="message" id="message" placeholder="您的消息或建议" required></textarea>

                    <!-- Submit -->
                    <button id="submit" type="submit" onclick="reply()">
                        <i class="icon-chat"></i> 发送
                    </button>

                </div>

            </div>

        </div>
    </div>
    <script>
        function reply() {
            var name = document.getElementById('name').value;
            var email = document.getElementById('email').value;
            var message = document.getElementById('message').value;

            $.ajax({
                url: '<?=Url::to(['contact/reply']) ?>',
                contentType: "application/x-www-form-urlencoded;charset=utf-8",
                type: "post",
                data: {
                    name: name,
                    email: email,
                    message: message
                },
                dataType: "json",
                success: function(result) {
                    if (result.code == 100000) {
                        alert("提交成功，您的建议我们会及时处理~");
                    } else {
                        alert(result.msg);
                    }
                },
                error: function(result) {
                    alert("发送失败，请重试或检查网络");
                }
            });

            return false;
        }

    </script>



