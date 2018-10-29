<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '文章名';

?>

<!-- ##### Single Blog Area Start ##### -->
<div class="single-blog-wrapper section-padding-0-100">

    <!-- Single Blog Area  -->
    <div class="single-blog-area blog-style-2 mb-50">
        <div class="single-blog-thumbnail">
            <?=Html::img('@web/img/bg-img/b5.jpg') ?>
            <div class="post-tag-content">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="post-date">
                                <a href="#"><?=date('d') ?><span><?=date('m') ?>月</span></a>
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
                        <a href="#" class="post-tag">Know you</a>
                        <h4><a href="#" class="post-headline mb-0"><?=$article_info['title'] ?></a></h4>
                        <div class="post-meta mb-50">
                            <p>By <a href="#"><?=$username ?></a></p>
                            <p> 阅读：<?=$readNumber ?></p>
                            <p> 评论：123</p>
                        </div>
                        <p>
                            <?=$article_info['content'] ?>
                        </p>
                    </div>
                </div>

                <!-- About Author -->
                <div class="blog-post-author mt-100 d-flex">
                    <div class="author-thumbnail">
                        <img src="<?=Url::to('@web/img/bg-img/b6.jpg') ?>" alt="">
                    </div>
                    <div class="author-info">
                        <div class="line"></div>
                        <span class="author-role">Author</span>
                        <h4><a href="#" class="author-name">James Morrison</a></h4>
                        <p>Curabitur venenatis efficitur lorem sed tempor. Integer aliquet tempor cursus. Nullam vestibulum convallis risus vel condimentum. Nullam auctor lorem in libero luctus, vel volutpat quam tincidunt. Nullam vestibulum convallis risus vel condimentum. Nullam auctor lorem in libero.</p>
                    </div>
                </div>

                <!-- Comment Area Start -->
                <div class="comment_area clearfix mt-70">
                    <h5 class="title">Comments</h5>

                    <ol>
                        <!-- Single Comment Area -->
                        <li class="single_comment_area">
                            <!-- Comment Content -->
                            <div class="comment-content d-flex">
                                <!-- Comment Author -->
                                <div class="comment-author">
                                    <img src="<?=Url::to('@web/img/bg-img/b7.jpg') ?>" alt="author">
                                </div>
                                <!-- Comment Meta -->
                                <div class="comment-meta">
                                    <a href="#" class="post-date">March 12</a>
                                    <p><a href="#" class="post-author">William James</a></p>
                                    <p>Efficitur lorem sed tempor. Integer aliquet tempor cursus. Nullam vestibulum convallis risus vel condimentum. Nullam auctor lorem in libero luctus, vel volutpat quam tincidunt.</p>
                                    <a href="#" class="comment-reply">Reply</a>
                                </div>
                            </div>
                            <ol class="children">
                                <li class="single_comment_area">
                                    <!-- Comment Content -->
                                    <div class="comment-content d-flex">
                                        <!-- Comment Author -->
                                        <div class="comment-author">
                                            <img src="<?=Url::to('@web/img/bg-img/b7.jpg') ?>" alt="author">
                                        </div>
                                        <!-- Comment Meta -->
                                        <div class="comment-meta">
                                            <a href="#" class="post-date">March 12</a>
                                            <p><a href="#" class="post-author">William James</a></p>
                                            <p>Efficitur lorem sed tempor. Integer aliquet tempor cursus. Nullam vestibulum convallis risus vel condimentum. Nullam auctor lorem in libero luctus, vel volutpat quam tincidunt.</p>
                                            <a href="#" class="comment-reply">Reply</a>
                                        </div>
                                    </div>
                                </li>
                            </ol>
                        </li>

                        <!-- Single Comment Area -->
                        <li class="single_comment_area">
                            <!-- Comment Content -->
                            <div class="comment-content d-flex">
                                <!-- Comment Author -->
                                <div class="comment-author">
                                    <img src="<?=Url::to('@web/img/bg-img/b7.jpg') ?>" alt="author">
                                </div>
                                <!-- Comment Meta -->
                                <div class="comment-meta">
                                    <a href="#" class="post-date">March 12</a>
                                    <p><a href="#" class="post-author">William James</a></p>
                                    <p>Efficitur lorem sed tempor. Integer aliquet tempor cursus. Nullam vestibulum convallis risus vel condimentum. Nullam auctor lorem in libero luctus, vel volutpat quam tincidunt.</p>
                                    <a href="#" class="comment-reply">Reply</a>
                                </div>
                            </div>
                        </li>
                    </ol>
                </div>

                <div class="post-a-comment-area mt-70">
                    <h5>Leave a reply</h5>
                    <!-- Reply Form -->
                    <form action="#" method="post">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="group">
                                    <input type="text" name="name" id="name" required>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>Name</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="group">
                                    <input type="email" name="email" id="email" required>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>Email</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group">
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
                                    <label>Comment</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn original-btn">Reply</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
