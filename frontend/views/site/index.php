<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Know You - begin your colorful life';

?>

<!-- Preloader -->
<div id="preloader">
    <div class="preload-content">
        <div id="original-load"></div>
    </div>
</div>

<!-- Subscribe Modal -->
<div class="subscribe-newsletter-area">
    <div class="modal fade" id="subsModal" tabindex="-1" role="dialog" aria-labelledby="subsModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <h5 class="title">Subscribe to my newsletter</h5>
                    <form action="#" class="newsletterForm" method="post">
                        <input type="email" name="email" id="subscribesForm2" placeholder="Your e-mail here">
                        <button type="submit" class="btn original-btn">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ##### Header Area Start ##### -->
<header class="header-area">

    <!-- Top Header Area -->
    <div class="top-header">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <!-- Breaking News Area -->
                <div class="col-12 col-sm-8">
                    <div class="breaking-news-area">
                        <div id="breakingNewsTicker" class="ticker">
                            <ul>
                                <li><a href="#">Hello World!</a></li>
                                <li><a href="#">Hello Universe!</a></li>
                                <li><a href="#">Hello Original!</a></li>
                                <li><a href="#">Hello Earth!</a></li>
                                <li><a href="#">Hello Colorlib!</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Top Social Area -->
                <div class="col-12 col-sm-4">
                    <div class="top-social-area">
                        <a href="#" data-toggle="tooltip" data-placement="bottom" title="Pinterest"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                        <a href="#" data-toggle="tooltip" data-placement="bottom" title="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        <a href="#" data-toggle="tooltip" data-placement="bottom" title="Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        <a href="#" data-toggle="tooltip" data-placement="bottom" title="Dribbble"><i class="fa fa-dribbble" aria-hidden="true"></i></a>
                        <a href="#" data-toggle="tooltip" data-placement="bottom" title="Behance"><i class="fa fa-behance" aria-hidden="true"></i></a>
                        <a href="#" data-toggle="tooltip" data-placement="bottom" title="Linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Logo Area -->
    <div class="logo-area text-center">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <a href="index.html" class="original-logo"><?=Html::img('@web/img/core-img/logo.png') ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="tlinks">Collect from <a href="http://www.cssmoban.com/" >网页模板</a></div>

    <!-- Nav Area -->
    <div class="original-nav-area" id="stickyNav">
        <div class="classy-nav-container breakpoint-off">
            <div class="container">
                <!-- Classy Menu -->
                <nav class="classy-navbar justify-content-between">

                    <!-- Subscribe btn -->
                    <div class="subscribe-btn">
                        <a href="#" class="btn subscribe-btn" data-toggle="modal" data-target="#subsModal">Subscribe</a>
                    </div>

                    <!-- Navbar Toggler -->
                    <div class="classy-navbar-toggler">
                        <span class="navbarToggler"><span></span><span></span><span></span></span>
                    </div>

                    <!-- Menu -->
                    <div class="classy-menu" id="originalNav">
                        <!-- close btn -->
                        <div class="classycloseIcon">
                            <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                        </div>

                        <!-- Nav Start -->
                        <div class="classynav">
                            <ul>
                                <li><a href="<?=Url::to(['site/index']) ?>">Home</a></li>
                                <li><a href="#">Pages</a>
                                    <ul class="dropdown">
                                        <li><a href="<?=Url::to(['site/index']) ?>">Home</a></li>
                                        <li><a href="about-us.html">About Us</a></li>
                                        <li><a href="single-post.html">Single Post</a></li>
                                        <li><a href="contact.html">Contact</a></li>
                                        <li><a href="coming-soon.html">Coming Soon</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">Catagory</a>
                                    <ul class="dropdown">
                                        <li><a href="#">Catagory 1</a></li>
                                        <li><a href="#">Catagory 1</a></li>
                                        <li><a href="#">Catagory 1</a>
                                            <ul class="dropdown">
                                                <li><a href="#">Catagory 2</a></li>
                                                <li><a href="#">Catagory 2</a></li>
                                                <li><a href="#">Catagory 2</a>
                                                    <ul class="dropdown">
                                                        <li><a href="#">Catagory 3</a></li>
                                                        <li><a href="#">Catagory 3</a></li>
                                                        <li><a href="#">Catagory 3</a></li>
                                                        <li><a href="#">Catagory 3</a></li>
                                                        <li><a href="#">Catagory 3</a></li>
                                                    </ul>
                                                </li>
                                                <li><a href="#">Catagory 2</a></li>
                                                <li><a href="#">Catagory 2</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Catagory 1</a></li>
                                        <li><a href="#">Catagory 1</a></li>
                                    </ul>
                                </li>
                                <li><a href="about-us.html">About Us</a></li>
                                <li><a href="#">Megamenu</a>
                                    <div class="megamenu">
                                        <ul class="single-mega cn-col-4">
                                            <li class="title">Headline 1</li>
                                            <li><a href="#">Mega Menu Item 1</a></li>
                                            <li><a href="#">Mega Menu Item 2</a></li>
                                            <li><a href="#">Mega Menu Item 3</a></li>
                                            <li><a href="#">Mega Menu Item 4</a></li>
                                            <li><a href="#">Mega Menu Item 5</a></li>
                                        </ul>
                                        <ul class="single-mega cn-col-4">
                                            <li class="title">Headline 2</li>
                                            <li><a href="#">Mega Menu Item 1</a></li>
                                            <li><a href="#">Mega Menu Item 2</a></li>
                                            <li><a href="#">Mega Menu Item 3</a></li>
                                            <li><a href="#">Mega Menu Item 4</a></li>
                                            <li><a href="#">Mega Menu Item 5</a></li>
                                        </ul>
                                        <ul class="single-mega cn-col-4">
                                            <li class="title">Headline 3</li>
                                            <li><a href="#">Mega Menu Item 1</a></li>
                                            <li><a href="#">Mega Menu Item 2</a></li>
                                            <li><a href="#">Mega Menu Item 3</a></li>
                                            <li><a href="#">Mega Menu Item 4</a></li>
                                            <li><a href="#">Mega Menu Item 5</a></li>
                                        </ul>
                                        <ul class="single-mega cn-col-4">
                                            <li class="title">Headline 4</li>
                                            <li><a href="#">Mega Menu Item 1</a></li>
                                            <li><a href="#">Mega Menu Item 2</a></li>
                                            <li><a href="#">Mega Menu Item 3</a></li>
                                            <li><a href="#">Mega Menu Item 4</a></li>
                                            <li><a href="#">Mega Menu Item 5</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>

                            <!-- Search Form  -->
                            <div id="search-wrapper">
                                <form action="#">
                                    <input type="text" id="search" placeholder="Search something...">
                                    <div id="close-icon"></div>
                                    <input class="d-none" type="submit" value="">
                                </form>
                            </div>
                        </div>
                        <!-- Nav End -->
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- ##### Header Area End ##### -->

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
