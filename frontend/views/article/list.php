<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '文章列表';

?>

<!-- ##### Blog Wrapper Start ##### -->
<div class="blog-wrapper section-padding-100 clearfix">

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-9">

                <?php
                    if (!empty($article_list)) {
                        foreach ($article_list as $_article) {
                            $month = date('m', strtotime($_article['created_at']));
                            $day = date('d', strtotime($_article['created_at']));
                ?>

                <div class="single-blog-area blog-style-2 mb-50 wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="1000ms">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-6">
                            <div class="single-blog-thumbnail">
                                <?=Html::img($_article['cover']) ?>
                                <div class="post-date">
                                    <a href="#"><?=$day ?> <span><?=$month ?></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <!-- Blog Content -->
                            <div class="single-blog-content">
                                <div class="line"></div>
                                <a href="#" class="post-tag"><?=!empty($tagMap[$_article['tag']]) ? $tagMap[$_article['tag']] : '无' ?></a>
                                <h4><a href="#" class="post-headline"><?=$_article['title'] ?></a></h4>
                                <p><?=substr($_article['content'], 0, 20) . '...' ?></p>
                                <div class="post-meta">
                                    <p>By <a href="#"><?=$user_info['username'] ?></a></p>
                                    <p>3 comments</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                        }
                    }
                ?>
                <!-- Single Blog Area  -->
                <div class="single-blog-area blog-style-2 mb-50 wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="1000ms">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-6">
                            <div class="single-blog-thumbnail">
                                <?=Html::img('@web/img/blog-img/3.jpg') ?>
                                <div class="post-date">
                                    <a href="#">12 <span>march</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <!-- Blog Content -->
                            <div class="single-blog-content">
                                <div class="line"></div>
                                <a href="#" class="post-tag">Lifestyle</a>
                                <h4><a href="#" class="post-headline">Party people in the house</a></h4>
                                <p>Curabitur venenatis efficitur lorem sed tempor. Integer aliquet tempor cursus. Nullam vestibulum convallis risus vel condimentum. Nullam auctor lorem in libero luctus, vel volutpat quam tincidunt.</p>
                                <div class="post-meta">
                                    <p>By <a href="#">james smith</a></p>
                                    <p>3 comments</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Single Blog Area  -->
                <div class="single-blog-area blog-style-2 mb-50 wow fadeInUp" data-wow-delay="0.3s" data-wow-duration="1000ms">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-6">
                            <div class="single-blog-thumbnail">
                                <?=Html::img('@web/img/blog-img/4.jpg') ?>
                                <div class="post-date">
                                    <a href="#">12 <span>march</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <!-- Blog Content -->
                            <div class="single-blog-content">
                                <div class="line"></div>
                                <a href="#" class="post-tag">Lifestyle</a>
                                <h4><a href="#" class="post-headline">We love colors in 2018</a></h4>
                                <p>Curabitur venenatis efficitur lorem sed tempor. Integer aliquet tempor cursus. Nullam vestibulum convallis risus vel condimentum. Nullam auctor lorem in libero luctus, vel volutpat quam tincidunt.</p>
                                <div class="post-meta">
                                    <p>By <a href="#">james smith</a></p>
                                    <p>3 comments</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Single Blog Area  -->
                <div class="single-blog-area blog-style-2 mb-50 wow fadeInUp" data-wow-delay="0.5s" data-wow-duration="1000ms">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-6">
                            <div class="single-blog-thumbnail">
                                <?=Html::img('@web/img/blog-img/5.jpg')?>
                                <div class="post-date">
                                    <a href="#">12 <span>march</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <!-- Blog Content -->
                            <div class="single-blog-content">
                                <div class="line"></div>
                                <a href="#" class="post-tag">Lifestyle</a>
                                <h4><a href="#" class="post-headline">Party people in the house</a></h4>
                                <p>Curabitur venenatis efficitur lorem sed tempor. Integer aliquet tempor cursus. Nullam vestibulum convallis risus vel condimentum. Nullam auctor lorem in libero luctus, vel volutpat quam tincidunt.</p>
                                <div class="post-meta">
                                    <p>By <a href="#">james smith</a></p>
                                    <p>3 comments</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Single Blog Area  -->
                <div class="single-blog-area blog-style-2 mb-50 wow fadeInUp" data-wow-delay="0.6s" data-wow-duration="1000ms">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-6">
                            <div class="single-blog-thumbnail">
                                <?=Html::img('@web/img/blog-img/6.jpg')?>
                                <div class="post-date">
                                    <a href="#">12 <span>march</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <!-- Blog Content -->
                            <div class="single-blog-content">
                                <div class="line"></div>
                                <a href="#" class="post-tag">Lifestyle</a>
                                <h4><a href="#" class="post-headline">We love colors in 2018</a></h4>
                                <p>Curabitur venenatis efficitur lorem sed tempor. Integer aliquet tempor cursus. Nullam vestibulum convallis risus vel condimentum. Nullam auctor lorem in libero luctus, vel volutpat quam tincidunt.</p>
                                <div class="post-meta">
                                    <p>By <a href="#">james smith</a></p>
                                    <p>3 comments</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Load More -->
                <div class="load-more-btn mt-100 wow fadeInUp" data-wow-delay="0.7s" data-wow-duration="1000ms">
                    <a href="#" class="btn original-btn">Read More</a>
                </div>
            </div>