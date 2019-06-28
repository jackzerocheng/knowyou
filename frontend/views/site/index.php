<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '简 · 默';

?>


<!-- ##### Hero Area Start 顶部滚动大图 ##### -->
<div class="hero-area">
    <!-- Hero Slides Area -->
    <div class="hero-slides owl-carousel">
        <!-- Single Slide -->
        <?php
            foreach ($banner_index_image as $line) {
        ?>

        <div class="single-hero-slide bg-img" style="background-image: url(<?=Url::to($line['img']) ?>);">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-12">
                        <div class="slide-content text-center">
                            <div class="post-tag">
                                <!--<a href="#" data-animation="fadeInUp"></a>-->
                            </div>
                            <h2 data-animation="fadeInUp" data-delay="250ms"><a href="<?=$line['link'] ?>"><?=$line['name'] ?></a></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
            }
        ?>
    </div>
</div>
<!-- ##### Hero Area End ##### -->

<!-- ##### Blog Wrapper Start ##### -->
<div class="blog-wrapper section-padding-100 clearfix">
    <div class="container">
        <div class="row align-items-end">
            <!-- Single Blog Area -->
            <div class="col-12 col-lg-4">
                <div class="single-blog-area clearfix mb-100">
                    <!-- Blog Content -->
                    <div class="single-blog-content">
                        <div class="line"></div>
                        <a href="#" class="post-tag">Lifestyle</a>
                        <h4><a href="#" class="post-headline">欢迎来到 简 · 默</a></h4>
                        <p>人来人往，春去秋来，世界之大，何处为家。愿 远方的你、孤独的你、可爱的你，心中存一份净土</p>
                        <a href="<?=Url::to(['article/create']) ?>"><button class="btn original-btn">我要发文</button></a>
                    </div>
                </div>
            </div>
            <!-- Single Blog Area -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="single-catagory-area clearfix mb-100">
                    <?=Html::img('http://data.jianmo.top/img/picture/1.jpg') ?>
                    <!-- Catagory Title -->
                    <div class="catagory-title">
                        <a href="<?=Url::to(['article/list']) ?>">看看文章</a>
                    </div>
                </div>
            </div>
            <!-- Single Blog Area -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="single-catagory-area clearfix mb-100">
                    <?=Html::img('http://data.jianmo.top/img/picture/2.jpg') ?>
                    <!-- Catagory Title -->
                    <div class="catagory-title">
                        <a href="#">逛逛论坛</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-9">

                <?php
                /**
                 * 展示最近动态文章
                 */
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
                                <a href="#" class="post-tag"><?=$tag_map[$_article['tag']]['name'] ?></a>
                                <h4><a href="<?=Url::toRoute(['/article/index', 'id' => $_article['id']]) ?>" class="post-headline"><?=$_article['title'] ?></a></h4>
                                <p><?=$_article['content'] ?></p>
                                <div class="post-meta">
                                    <p>By <a href="#"><?=$_article['username'] ?></a></p>
                                    <p><?=$_article['redis_read_number'] . '人已读' ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }
                } else {
                ?>

                    <div class="single-blog-area blog-style-2 mb-50 wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="1000ms">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-6">
                                <div class="single-blog-thumbnail">
                                    <?=Html::img('http://data.jianmo.top/img/default/not_found.gif') ?>
                                    <div class="post-date">
                                        <a href="#"><?=date('d') ?> <span><?=date('m') ?></span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <!-- Blog Content -->
                                <div class="single-blog-content">
                                    <div class="line"></div>
                                    <p>不可能，怎么会什么都没有！！！</p>
                                    <div class="post-meta">
                                        <p>By <a href="#">异次元程序员</a></p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php

                }
                ?>

                <!-- Load More -->
                <div class="load-more-btn mt-100 wow fadeInUp" data-wow-delay="0.7s" data-wow-duration="1000ms">
                    <a href="<?=Url::to(['article/create']) ?>"><button class="btn original-btn">我要发文</button></a>
                </div>
            </div>

            <!-- ##### Sidebar Area ##### -->
            <div class="col-12 col-md-4 col-lg-3">
                <div class="post-sidebar-area">

                    <div class="sidebar-widget-area">
                        <h5 class="title">栏目</h5>
                        <div class="widget-content">
                            <ul class="tags">
                                <?php
                                if (!empty($tag_map)) {
                                    foreach ($tag_map as $_tag) {
                                        echo "<li><a href='".Url::toRoute(['article/list'])."?tag=".$_tag['type']."'>{$_tag['name']}</a></li>";
                                    }
                                } else {
                                    echo "什么都没有。。(T.T)";
                                }

                                ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Widget Area -->
                    <div class="sidebar-widget-area">
                        <h5 class="title">您的点击，是网站存活的动力↓</h5>
                        <a href="#"><?=Html::img('http://data.jianmo.top/img/picture/adver_git.gif') ?></a>
                    </div>

                    <!-- Widget Area -->
                    <div class="sidebar-widget-area">
                        <h5 class="title">关于我们</h5>

                        <div class="widget-content">

                            <!-- Single Blog Post -->
                            <div class="single-blog-post d-flex align-items-center widget-post">
                                <p>微信公众号：异次元程序员</p>
                            </div>

                            <!-- Single Blog Post -->
                            <div class="single-blog-post d-flex align-items-center widget-post">
                                <p>邮箱：igetjzc@outlook.com</p>
                            </div>

                            <!-- Single Blog Post -->
                            <div class="single-blog-post d-flex align-items-center widget-post">
                                <img src="http://data.jianmo.top/img/default/qrcode.png">
                            </div>
                        </div>
                    </div>
                </div>
            </div>




