<?php
use yii\helpers\Url;

$this->title = '联系我们';

?>
<link rel="stylesheet" href="<?=Url::to('@web/css/contact_form/style.css') ?>">
<link rel="stylesheet" href="<?=Url::to('@web/css/contact_form/style2.css') ?>">
<script src="<?=Url::to('@web/js/jquery/jquery-2.2.4.min.js') ?>"></script>
<script src="<?=Url::to('@web/js/index.js') ?>"></script>

<div class="blog-wrapper section-padding-100 clearfix">
    <div class="container">
        <div class="row align-items-end">

            <form action="" id="contact" >

                <!-- Logo, title and informative content -->
                <div id="logo" class="bouncing">
                    <em class="icon-food"></em>
                </div>

                <h1 id="title"> Contact Us  </h1>
                <p id="pre">
                    If you wish to congratulate us about our perfectly cooked noodles, or just to remind us how awesome we are, feel free to use this contact form.
                </p>
                <p id="post">
                    Your message was sent ! <br/>
                    We will provide you with an answer as soon as possible.<br/>
                    Meanwhile, you may want to check <a href='http://goo.gl/VxTHcB' target='_blank'>our new menu</a>.
                </p>

                <!-- Form fields wrapper -->
                <div id="wrapper" class="clearfix">

                    <!-- Name -->
                    <input type="text" class="" name="name" placeholder="Name" required>


                    <!-- Email -->
                    <input type="email"  class="" name="email" placeholder="Email Address" required>


                    <!-- Contact -->
                    <textarea name="" id="" placeholder="Enter your message" required></textarea>

                    <!-- Submit -->
                    <button id="submit" type="submit" >
                        <i class="icon-chat"></i> Send message
                    </button>

                </div>

            </form>

        </div>
    </div>


