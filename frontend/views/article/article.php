<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $article_info['title'];

$month = date('m', strtotime($article_info['created_at']));
$day = date('d', strtotime($article_info['created_at']));
?>

<!-- ##### Single Blog Area Start ##### -->
<div class="single-blog-wrapper section-padding-0-100">

    <!-- Single Blog Area  -->
    <div class="single-blog-area blog-style-2 mb-50">
        <div class="single-blog-thumbnail">
            <?=Html::img($article_info['cover']) ?>
            <div class="post-tag-content">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="post-date">
                                <a href="#"><?=$day ?><span><?=$month ?>月</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <!-- ##### Post Content Area ##### -->
            <div class="col-12 col-lg-9">
                <!-- Single Blog Area  -->
                <div class="single-blog-area blog-style-2 mb-50">
                    <!-- Blog Content -->
                    <div class="single-blog-content">
                        <div class="line"></div>
                        <a href="#" class="post-tag"><?=$article_info['tag_msg'] ?></a>
                        <h4><a href="#" class="post-headline mb-0"><?=$article_info['title'] ?></a></h4>
                        <div class="post-meta mb-50">
                            <p>By <a href="#"><?=$user_info['username'] ?></a></p>
                            <p><?='阅读:' . $read_number . ' | ' ?></p>
                            <p><?='点赞:' . $article_info['praise_number'] . ' | ' ?></p>
                            <p><?='评论:' . $comment_number . ' | ' ?></p>
                            <hr>
                        </div>
                    </div>

                    <div>
                        <strong>
                            <p style="font-size: larger;">
                                <?=$article_info['content'] ?>
                            </p>
                        </strong>
                    </div>
                </div>

                <!-- About Author -->
                <div class="blog-post-author mt-100 d-flex">
                    <div class="author-thumbnail">
                        <img src="<?=Url::to($user_info['head']) ?>" alt="">
                    </div>
                    <div class="author-info">
                        <div class="line"></div>
                        <span class="author-role">Author</span>
                        <h4><a href="#" class="author-name"><?=$user_info['username'] ?></a></h4>
                        <p><?=$user_info['signature'] ?></p>
                    </div>
                </div>

                <!-- Comment Area Start -->
                <div class="comment_area clearfix mt-50">
                    <h2 class="title">评论</h2>
                    <ol>
                    <?php
                        if (!empty($comment_list)) {
                            foreach ($comment_list as $k => $v) {
                    ?>

                        <!-- Single Comment Area -->
                        <li class="single_comment_area">
                            <!-- Comment Content -->
                            <div class="comment-content d-flex">
                                <!-- Comment Author -->
                                <div class="comment-author">
                                    <img src="<?=Url::to($v['head']) ?>" alt="author">
                                </div>
                                <!-- Comment Meta -->
                                <div class="comment-meta">
                                    <a href="#" class="post-date"><?=$v['created_at'] ?></a>
                                    <p><a href="#" class="post-author"><?=$v['username'] ?></a></p>
                                    <p><?=$v['content'] ?></p>
                                    <input id="<?=$v['id'] ?>" style="width:500px" placeholder="请文明评论，友善讨论">&nbsp;&nbsp;
                                    <a href="#" onclick="reply_comment(<?=$v['id'] ?>,<?=$v['id'] ?>)" style="color:blue">回复</a>
                                </div>
                            </div>
                            <?php
                                if (!empty($v['child_comment'])) {
                                    foreach ($v['child_comment'] as $item => $value) {//楼中楼
                            ?>

                                <ol class="children">
                                    <li class="single_comment_area">
                                        <!-- Comment Content -->
                                        <div class="comment-content d-flex">
                                            <!-- Comment Author -->
                                            <div class="comment-author">
                                                <img src="<?=Url::to($value['head']) ?>" alt="author">
                                            </div>
                                            <!-- Comment Meta -->
                                            <div class="comment-meta">
                                                <a href="#" class="post-date"><?=$value['created_at'] ?></a>
                                                <p><a href="#" class="post-author"><?=$value['username'] ?></a></p>
                                                <p><?=$value['content'] ?></p>
                                                <input id="<?=$value['id'] ?>" style="width:500px" placeholder="请文明评论，友善讨论">&nbsp;&nbsp;
                                                <a href="#" onclick="reply_comment(<?=$value['id'] ?>,<?=$v['id'] ?>)" style="color:blue">回复</a>
                                            </div>
                                        </div>
                                    </li>
                                </ol>

                            <?php
                                    }
                                }
                            ?>

                        </li>

                    <?php
                            }
                        } else { //没有评论的情况
                    ?>

                        <li class="single_comment_area">
                            <div class="comment-content d-flex">
                                <p>当前还没人评论哦，快来抢沙发~</p>
                            </div>

                        </li>

                    <?php
                        }
                    ?>
                    </ol>
                </div>


                <div class="post-a-comment-area mt-50">
                    <!-- Reply Form -->
                    <div class="col-12">
                        <textarea id="submit_comment" placeholder="请文明评论，友善讨论哦" style="width:800px;height:200px;word-wrap:break-word"></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn original-btn" onclick="reply_comment('submit_comment',0)">回复</button>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                function reply_comment(comment_id,parent_id) {
                    var comment_content = window.document.getElementById(comment_id).value;

                    if (comment_content == "") {
                        alert("请填写评论内容");
                        return false;
                    }

                    $.ajax({
                        url: "http://localhost:7888/knowyou/frontend/web/index.php?r=comment%2Freply",
                        contentType: "application/x-www-form-urlencode",
                        type: "post",
                        data: {
                            article_id: <?=$article_info['id'] ?>,
                            content: comment_content,
                            uid: <?=$user_info['uid'] ?>,
                            parent_id: parent_id
                        },
                        dataType: "json",
                        success: function(result) {
                            if (result.code == 100000) {
                                alert("回复成功!(大流量情况下评论可能会延迟刷新哦>_<)");
                            } else {
                                alert(result.msg);
                            }
                        },
                        error: function(result) {
                            alert("发布失败，请重试或检查网络");
                        }
                    })

                    return false;
                }
            </script>
