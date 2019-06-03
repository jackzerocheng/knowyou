<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

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
                                <a href="#" class="post-tag"><?=!empty($tag_map[$_article['tag']]) ? $tag_map[$_article['tag']]['name'] : '无' ?></a>
                                <h4><a href="<?=Url::to(['article/index', 'id' => $_article['id']]) ?>" class="post-headline" style="color: green"><?=$_article['title'] ?></a></h4>
                                <p><?=substr($_article['content'], 0, 20) . '...' ?></p>
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
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <!-- Blog Content -->
                            <div class="single-blog-content">
                                <div class="line"></div>
                                <a href="#" class="post-tag"></a>
                                <p>对不起，你想要的我们还没有(T.T),<a href="<?=Url::to(['article/list']) ?>" class="post-headline">看看别的吧</a></p>
                                <h4></h4>
                                <p>或者说说你有什么有趣事吧<a href="<?=Url::to(['article/create']) ?>">我要发文</a></p>
                                <p>有更好的意见？<a href="<?=Url::to(['contact/index']) ?>">联系我们</a></p>
                                <div class="post-meta">
                                    <p>By <a href="#">JZC</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                    }
                ?>
                <div>
                    <?=LinkPager::widget(['pagination' => $pages]) ?>
                </div>

                <!--
                <div class="load-more-btn mt-100 wow fadeInUp" data-wow-delay="0.7s" data-wow-duration="1000ms">
                    <a href="#" class="btn original-btn">换一波</a>
                </div>
                -->
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
                                        echo "<li><a href='{$_tag['type']}'>{$_tag['name']}</a></li>";
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