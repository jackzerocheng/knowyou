<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Know You - begin your colorful life';

?>


<!-- ##### Hero Area Start ##### -->
<div class="hero-area">
    <!-- Hero Slides Area -->
    <div class="hero-slides owl-carousel">
        <!-- Single Slide -->
        <div class="single-hero-slide bg-img" style="background-image: url(<?=Url::to('@web/img/bg-img/b2.jpg') ?>);">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-12">
                        <div class="slide-content text-center">
                            <div class="post-tag">
                                <a href="#" data-animation="fadeInUp">lifestyle</a>
                            </div>
                            <h2 data-animation="fadeInUp" data-delay="250ms"><a href="single-post.html">Take a look at last night’s party!</a></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Single Slide -->
        <div class="single-hero-slide bg-img" style="background-image: url(<?=Url::to('@web/img/bg-img/b1.jpg') ?>);">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-12">
                        <div class="slide-content text-center">
                            <div class="post-tag">
                                <a href="#" data-animation="fadeInUp">lifestyle</a>
                            </div>
                            <h2 data-animation="fadeInUp" data-delay="250ms"><a href="single-post.html">Take a look at last night’s party!</a></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Single Slide -->
        <div class="single-hero-slide bg-img" style="background-image: url(<?=Url::to('@web/img/bg-img/b3.jpg') ?>);">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-12">
                        <div class="slide-content text-center">
                            <div class="post-tag">
                                <a href="#" data-animation="fadeInUp">lifestyle</a>
                            </div>
                            <h2 data-animation="fadeInUp" data-delay="250ms"><a href="single-post.html">Take a look at last night’s party!</a></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                        <h4><a href="#" class="post-headline">Welcome to this Lifestyle blog</a></h4>
                        <p>Curabitur venenatis efficitur lorem sed tempor. Integer aliquet tempor cursus. Nullam vestibulum convallis risus vel condimentum. Nullam auctor lorem in libero luctus, vel volutpat quam tincidunt. Morbi sodales, dolor id ultricies dictum</p>
                        <a href="#" class="btn original-btn">Read More</a>
                    </div>
                </div>
            </div>
            <!-- Single Blog Area -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="single-catagory-area clearfix mb-100">
                    <?=Html::img('@web/img/blog-img/1.jpg') ?>
                    <!-- Catagory Title -->
                    <div class="catagory-title">
                        <a href="#">Lifestyle posts</a>
                    </div>
                </div>
            </div>
            <!-- Single Blog Area -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="single-catagory-area clearfix mb-100">
                    <?=Html::img('@web/img/blog-img/2.jpg') ?>
                    <!-- Catagory Title -->
                    <div class="catagory-title">
                        <a href="#">latest posts</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-9">

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
                <div class="single-blog-area blog-style-2 mb-50 wow fadeInUp" data-wow-delay="0.4s" data-wow-duration="1000ms">
                    <div class="row">
                        <div class="col-12">
                            <div class="single-blog-thumbnail">
                                <?=Html::img('@web/img/blog-img/7.jpg')?>
                                <div class="post-date">
                                    <a href="#">10 <span>march</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <!-- Blog Content -->
                            <div class="single-blog-content mt-50">
                                <div class="line"></div>
                                <a href="#" class="post-tag">Lifestyle</a>
                                <h4><a href="#" class="post-headline">10 Tips to organize the perfect party</a></h4>
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
        </div>
    </div>
</div>
<!-- ##### Blog Wrapper End ##### -->

<!-- ##### Instagram Feed Area Start ##### -->
<div class="instagram-feed-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="insta-title">
                    <h5>Follow us @ Instagram</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Instagram Slides -->
    <div class="instagram-slides owl-carousel">
        <!-- Single Insta Feed -->
        <div class="single-insta-feed">
            <?=Html::img('@web/img/instagram-img/1.png') ?>
            <!-- Hover Effects -->
            <div class="hover-effects">
                <a href="#" class="d-flex align-items-center justify-content-center"><i class="fa fa-instagram"></i></a>
            </div>
        </div>
        <!-- Single Insta Feed -->
        <div class="single-insta-feed">
            <?=Html::img('@web/img/instagram-img/2.png') ?>
            <!-- Hover Effects -->
            <div class="hover-effects">
                <a href="#" class="d-flex align-items-center justify-content-center"><i class="fa fa-instagram"></i></a>
            </div>
        </div>
        <!-- Single Insta Feed -->
        <div class="single-insta-feed">
            <?=Html::img('@web/img/instagram-img/3.png') ?>
            <!-- Hover Effects -->
            <div class="hover-effects">
                <a href="#" class="d-flex align-items-center justify-content-center"><i class="fa fa-instagram"></i></a>
            </div>
        </div>
        <!-- Single Insta Feed -->
        <div class="single-insta-feed">
            <?=Html::img('@web/img/instagram-img/4.png') ?>
            <!-- Hover Effects -->
            <div class="hover-effects">
                <a href="#" class="d-flex align-items-center justify-content-center"><i class="fa fa-instagram"></i></a>
            </div>
        </div>
        <!-- Single Insta Feed -->
        <div class="single-insta-feed">
            <?=Html::img('@web/img/instagram-img/5.png') ?>
            <!-- Hover Effects -->
            <div class="hover-effects">
                <a href="#" class="d-flex align-items-center justify-content-center"><i class="fa fa-instagram"></i></a>
            </div>
        </div>
        <!-- Single Insta Feed -->
        <div class="single-insta-feed">
            <?=Html::img('@web/img/instagram-img/6.png') ?>
            <!-- Hover Effects -->
            <div class="hover-effects">
                <a href="#" class="d-flex align-items-center justify-content-center"><i class="fa fa-instagram"></i></a>
            </div>
        </div>
        <!-- Single Insta Feed -->
        <div class="single-insta-feed">
            <?=Html::img('@web/img/instagram-img/7.png') ?>
            <!-- Hover Effects -->
            <div class="hover-effects">
                <a href="#" class="d-flex align-items-center justify-content-center"><i class="fa fa-instagram"></i></a>
            </div>
        </div>
    </div>
</div>
<!-- ##### Instagram Feed Area End ##### -->
