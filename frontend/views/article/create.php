<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '发表文章';
?>

<!-- ##### Contact Area Start ##### -->
<section class="contact-area section-padding-100">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Contact Form Area -->
            <div class="col-12 col-md-10 col-lg-9">
                <div class="contact-form">
                    <h5>表达你的自我</h5>
                    <?=Html::beginForm(['article/create'], 'post') ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="group">
                                <?=Html::input('text', 'subject', '', ['required', 'id' => 'subject', 'placeholder' => '标题']) ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group">
                                <?=Html::fileInput('cover_image') ?>
                                <?=Html::img('') ?>
                                <input type="text" name="subject" id="subject" required>
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Subject</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group">
                                <textarea name="message" id="message" required></textarea>
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Message</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn original-btn">Send Message</button>
                        </div>
                    </div>
                    <?=Html::endForm() ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ##### Contact Area End ##### -->

