<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '简 · 默';

?>


<!-- ##### Hero Area Start ##### -->
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
                                <a href="#" data-animation="fadeInUp">每周精选</a>
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
                    <?=Html::img('@web/img/blog-img/1.jpg') ?>
                    <!-- Catagory Title -->
                    <div class="catagory-title">
                        <a href="<?=Url::to(['article/list']) ?>">看看文章</a>
                    </div>
                </div>
            </div>
            <!-- Single Blog Area -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="single-catagory-area clearfix mb-100">
                    <?=Html::img('@web/img/blog-img/2.jpg') ?>
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
                 * 混合feed流
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
                                <a href="#" class="post-tag"><?=$_article['tag'] ?></a>
                                <h4><a href="#" class="post-headline"><?=$_article['title'] ?></a></h4>
                                <p><?=$_article['content'] ?></p>
                                <div class="post-meta">
                                    <p>By <a href="#"><?=$user_info[$_article['uid']]['username'] ?></a></p>
                                    <p><?=$_article['redis_read_number'] . '人已读' ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }
                } else {

                }
                ?>

                <!-- Load More -->
                <div class="load-more-btn mt-100 wow fadeInUp" data-wow-delay="0.7s" data-wow-duration="1000ms">
                    <a href="#" class="btn original-btn">换一批</a>
                </div>
            </div>

            <!-- ##### Sidebar Area ##### -->
            <div class="col-12 col-md-4 col-lg-3">
                <div class="post-sidebar-area">

                    <!-- Widget Area -->
                    <div class="sidebar-widget-area">
                        <form action="#" class="search-form">
                            <input type="search" name="search" id="searchForm" placeholder="Search">
                            <input type="submit" value="submit">
                        </form>
                    </div>

                    <!-- Widget Area -->
                    <div class="sidebar-widget-area">
                        <h5 class="title subscribe-title">Subscribe to my newsletter</h5>
                        <div class="widget-content">
                            <form action="#" class="newsletterForm">
                                <input type="email" name="email" id="subscribesForm" placeholder="Your e-mail here">
                                <button type="submit" class="btn original-btn">Subscribe</button>
                            </form>
                        </div>
                    </div>

                    <!-- Widget Area -->
                    <div class="sidebar-widget-area">
                        <h5 class="title">Advertisement</h5>
                        <a href="#"><?=Html::img('@web/img/bg-img/add.gif') ?></a>
                    </div>

                    <!-- Widget Area -->
                    <div class="sidebar-widget-area">
                        <h5 class="title">Latest Posts</h5>

                        <div class="widget-content">

                            <!-- Single Blog Post -->
                            <div class="single-blog-post d-flex align-items-center widget-post">
                                <!-- Post Thumbnail -->
                                <div class="post-thumbnail">
                                    <?=Html::img('@web/img/blog-img/lp1.jpg') ?>
                                </div>
                                <!-- Post Content -->
                                <div class="post-content">
                                    <a href="#" class="post-tag">Lifestyle</a>
                                    <h4><a href="#" class="post-headline">Party people in the house</a></h4>
                                    <div class="post-meta">
                                        <p><a href="#">12 March</a></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Blog Post -->
                            <div class="single-blog-post d-flex align-items-center widget-post">
                                <!-- Post Thumbnail -->
                                <div class="post-thumbnail">
                                    <?=Html::img('@web/img/blog-img/lp2.jpg') ?>
                                </div>
                                <!-- Post Content -->
                                <div class="post-content">
                                    <a href="#" class="post-tag">Lifestyle</a>
                                    <h4><a href="#" class="post-headline">A sunday in the park</a></h4>
                                    <div class="post-meta">
                                        <p><a href="#">12 March</a></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Blog Post -->
                            <div class="single-blog-post d-flex align-items-center widget-post">
                                <!-- Post Thumbnail -->
                                <div class="post-thumbnail">
                                    <?=Html::img('@web/img/blog-img/lp3.jpg') ?>
                                </div>
                                <!-- Post Content -->
                                <div class="post-content">
                                    <a href="#" class="post-tag">Lifestyle</a>
                                    <h4><a href="#" class="post-headline">Party people in the house</a></h4>
                                    <div class="post-meta">
                                        <p><a href="#">12 March</a></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Blog Post -->
                            <div class="single-blog-post d-flex align-items-center widget-post">
                                <!-- Post Thumbnail -->
                                <div class="post-thumbnail">
                                    <?=Html::img('@web/img/blog-img/lp4.jpg') ?>
                                </div>
                                <!-- Post Content -->
                                <div class="post-content">
                                    <a href="#" class="post-tag">Lifestyle</a>
                                    <h4><a href="#" class="post-headline">A sunday in the park</a></h4>
                                    <div class="post-meta">
                                        <p><a href="#">12 March</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Widget Area -->
                    <div class="sidebar-widget-area">
                        <h5 class="title">Tags</h5>
                        <div class="widget-content">
                            <ul class="tags">
                                <li><a href="#">design</a></li>
                                <li><a href="#">fashion</a></li>
                                <li><a href="#">travel</a></li>
                                <li><a href="#">music</a></li>
                                <li><a href="#">party</a></li>
                                <li><a href="#">video</a></li>
                                <li><a href="#">photography</a></li>
                                <li><a href="#">adventure</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>




