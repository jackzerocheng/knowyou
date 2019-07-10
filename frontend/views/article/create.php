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
                    <form id="create_article">
                        <div class="row">
                            <div class="col-12">
                                <div class="group">
                                    <?=Html::input('text', 'subject', '', ['id' => 'subject', 'placeholder' => '标题']) ?>
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
                                    <textarea id="content" name="content" rows="30" cols="70" placeholder="文章内容..." style="height: 300px"></textarea>
                                    <script type="text/javascript">
                                        window.UEDITOR_HOME_URL = "./ueditor/";
                                        var ue = UE.getEditor("content");
                                    </script>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn original-btn" onclick="createArticle()">发布文章</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function createArticle() {
        var subject = document.getElementById('subject').value;
        if (subject == '' || subject == null) {
            alert('缺少标题！');
            return false;
        }

        $.ajax({
            url: '<?=Url::to(['article/create']) ?>',
            contentType: "application/x-www-form-urlencoded;charset=utf-8",
            type: "post",
            data: $('#create_article').serialize(),
            dataType: "json",
            success: function(result) {
                if (result.code == 100000) {
                    var id = result.data.article_id;
                    alert("发布成功，即将跳转至文章详情页>>>");
                    var baseUrl = '<?=Url::to(['article/index']) ?>';
                    if (baseUrl.indexOf("?") != -1) {
                        window.href = baseUrl + '&id=' + id;
                    } else {
                        window.href = baseUrl + '?id=' + id;
                    }
                } else {
                    alert(result.msg);
                    return false;
                }
            },
            error: function(result) {
                alert("发布失败，请重试或检查网络");
            }
        });

        return false;
    }


</script>
<!-- ##### Contact Area End ##### -->

