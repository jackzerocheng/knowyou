<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\IndexAsset;
use common\models\BannerModel;
use common\models\UserModel;
use common\models\MenuModel;

IndexAsset::register($this);

//首页滚动信息
$bannerModel = new BannerModel();

$condition = [
    'platform_id' => $bannerModel::PLATFORM_WEB,
    'status'      => $bannerModel::STATUS_SHOWING
];
$bannerList = $bannerModel->getListByCondition($condition);

$wordList = array();//首页滚动字幕
$topImage = array();//首页顶部图片
$footerImage = array();//首页底部滚动图片
if (!empty($bannerList)) {
    foreach ($bannerList as $k => $v) {
        switch ($v['type']) {
            case $bannerModel::TYPE_INDEX_WORD_MESSAGE :
                $wordList[] = $v;
                break;
            case $bannerModel::TYPE_INDEX_TOP_IMAGE :
                $topImage[] = $v;
                break;
            case $bannerModel::TYPE_FOOTER_ROLL_IMAGE :
                $footerImage[] = $v;
                break;
            default :
                break;
        }
    }
}

//控制按钮显示,用户信息
$isLogin = false;
$userInfo = array();
$user = new UserModel();
if ($uid = $user->getSession()) {
    $userInfo = $user->getOneByCondition($uid, ['uid' => $uid]);
    $isLogin = true;
}

//获取菜单列表
$menuList = (new MenuModel())->getMenuList();
?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="keywords" content="简默,社交,论坛,博客,新闻,文章,交友,社区,美文,美图,文艺,交流,心情">
        <meta name="description" content="一个开放的平台，天南海北，无所不谈。人来人往，唯我独醉">
        <meta name="baidu-site-verification" content="kDVUlX6sBx" /><!-- 百度验证 -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <link rel="icon" href="<?=Url::to('@web/favicon.ico') ?>">
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
<!--     头部     -->
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
                        <h5 class="title">大人，你想要做什么</h5>
                        <p>您的账号是：<?=!empty($userInfo['uid']) ? $userInfo['uid'] : '' ?></p>
                        <form action="#" class="newsletterForm" method="post">
                            <!--<input type="email" name="email" id="subscribesForm2" placeholder="Your e-mail here">-->
                            <a href="#"><button type="button" class="btn original-btn">个人主页</button></a>
                            <a href="<?=Url::toRoute('/site/logout') ?>"><button type="button" class="btn original-btn">退出登录</button></a>
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
                                    <?php
                                    if (!empty($wordList)) {
                                        foreach ($wordList as $line) {
                                            echo "<li><a href='{$line['link']}'>{$line['name']}</a></li>";
                                        }
                                    } else {
                                        echo "<li><a href='#'>服务器君没什么话好说</a></li>";
                                    }
                                    ?>
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

        <div class="form-style-agile">
            <p style="text-align: center;color: red"><?=Yii::$app->session->getFlash('message') ?></p>
        </div>

        <!-- Logo Area -->
        <div class="logo-area text-center">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-12">
                        <a href="<?= !empty($topImage) ? $topImage[0]['link'] : 'http://data.jianmo.top/img/picture/eye.png' ?>" title="凝视深渊" class="original-logo">
                            <img src="<?= (!empty($topImage) ? $topImage[0]['img'] : 'http://data.jianmo.top/img/picture/eye.png') ?>" style="width:20%;"></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nav Area -->
        <div class="original-nav-area" id="stickyNav">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <!-- Classy Menu -->
                    <nav class="classy-navbar justify-content-between">

                        <!-- Subscribe btn -->
                        <div class="subscribe-btn">
                            <?php
                                // 判断用户是否登录选择展示内容
                                if ($isLogin) {
                                    echo "<a href=\"#\" class=\"btn subscribe-btn\" data-toggle=\"modal\" data-target=\"#subsModal\">{$userInfo['username']}，你好</a>";
                                } else {
                                    echo "<a href=\"" . Url::toRoute('/login/index') . "\" class=\"btn subscribe-btn\">登录/注册</a>";
                                }
                            ?>

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
                                <li><a href="<?=Url::toRoute('/site/index') ?>">Home</a></li>
                                <?php
                                    if (!empty($menuList)) {
                                        foreach ($menuList as $menu) {
                                ?>

                                <li><a href="<?=$menu['url'] ?>"><?=$menu['name'] ?></a>
                                    <?php
                                    if (!empty($menu['child_menu'])) {
                                        echo "<ul class='dropdown'>";
                                        foreach ($menu['child_menu'] as $_line) {
                                            echo "<li><a href=\"{$_line['url']}\">{$_line['name']}</a></li>";
                                        }
                                        echo "</ul>";
                                    }
                                    ?>
                                </li>

                                <?php
                                        }
                                    }
                                ?>
                                </ul>

                                <!-- Search Form  -->
                                <div id="search-wrapper">
                                    <?=Html::beginForm(['article/list'], 'post', ['id' => 'searchForm']) ?>
                                    <?=Html::input('text', 'search', '', ['placeholder' => '搜索关键字', 'id' => 'search', 'autocomplete' => 'off']) ?>
                                    <div id="close-icon"></div>
                                    <?=Html::submitInput('', ['class' => 'd-none']) ?>
                                    <?=Html::endForm() ?>
                                </div>
                            </div>
                            <!-- Nav End -->
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>



    <?= $content ?>


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
                            <h5><a href="#">加入我们@JZC</a></h5>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Instagram Slides -->
            <div class="instagram-slides owl-carousel">
                <?php
                    if (!empty($footerImage)) {
                        foreach ($footerImage as $line) {
                ?>
                    <div class="single-insta-feed">
                        <?=Html::img($line['img']) ?>
                        <!-- Hover Effects -->
                        <div class="hover-effects">
                            <a href="<?=$line['link'] ?>" class="d-flex align-items-center justify-content-center"><i class="fa fa-instagram"></i></a>
                        </div>
                    </div>
                <?php
                        }
                    }
                ?>

            </div>
        </div>
        <!-- ##### Instagram Feed Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
    <footer class="footer-area text-center">
        <div class="container">
            <div class="row">
                <div class="col-12">

                    <!-- Footer Nav Area -->
                    <div class="classy-nav-container breakpoint-off">
                        <!-- Classy Menu -->
                        <nav class="classy-navbar justify-content-center">

                            <!-- Navbar Toggler -->
                            <div class="classy-navbar-toggler">
                                <span class="navbarToggler"><span></span><span></span><span></span></span>
                            </div>

                            <!-- Menu -->
                            <div class="classy-menu">

                                <!-- close btn -->
                                <div class="classycloseIcon">
                                    <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                                </div>

                                <!-- Nav Start -->
                                <div class="classynav">
                                    <ul>
                                        <li><a href="<?=Url::to('site/index') ?>">Home</a></li>
                                        <?php
                                            foreach ($menuList as $menu) {
                                        ?>
                                        <li><a href="<?=$menu['url'] ?>"><?=$menu['name'] ?></a></li>
                                        <?php
                                            }
                                        ?>
                                    </ul>
                                </div>
                                <!-- Nav End -->
                            </div>
                        </nav>
                    </div>

                    <!-- Footer Social Area -->
                    <div class="footer-social-area mt-30">
                        <a href="#" data-toggle="tooltip" data-placement="top" title="Pinterest"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                        <a href="#" data-toggle="tooltip" data-placement="top" title="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        <a href="#" data-toggle="tooltip" data-placement="top" title="Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        <a href="#" data-toggle="tooltip" data-placement="top" title="Dribbble"><i class="fa fa-dribbble" aria-hidden="true"></i></a>
                        <a href="#" data-toggle="tooltip" data-placement="top" title="Behance"><i class="fa fa-behance" aria-hidden="true"></i></a>
                        <a href="#" data-toggle="tooltip" data-placement="top" title="Linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- copyright -->
        <div class="footer">
            <p>Copyright © <script>document.write(new Date().getFullYear());</script>.JZC All rights reserved.</p>
        </div>
    </footer>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>