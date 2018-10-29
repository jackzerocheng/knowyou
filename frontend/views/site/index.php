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




