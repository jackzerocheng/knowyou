<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '发表文章';
?>
<!-- 引入ueditor -->
<script src="./ueditor/ueditor.config.js"></script>
<script src="./ueditor/ueditor.all.js"></script>
<!-- ##### Contact Area Start ##### -->
<section class="contact-area section-padding-100">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Contact Form Area -->
            <div class="col-12 col-md-10 col-lg-9">
                <p>公告：发表文章严禁色情低俗违法内容。文章排版优秀，图片清晰更容易上热门哦</p>
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
                                <p>封面：(未选择则由系统生成)</p>
                                <?=Html::fileInput('cover') ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group">
                                <textarea name="content" id="content" rows="30" cols="70" placeholder="文章内容..." style="height: 300px" required></textarea>
                                <script type="text/javascript">
                                    window.UEDITOR_HOME_URL = "./ueditor/";
                                    UE.getEditor("content");
                                </script>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn original-btn">发布文章</button>
                        </div>
                    </div>
                    <?=Html::endForm() ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ##### Contact Area End ##### -->

