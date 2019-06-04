<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\AdminModel;
use common\models\MenuModel;
use common\lib\Config;

AppAsset::register($this);

$uid = Yii::$app->session->get(AdminModel::ADMIN_USER_SESSION_KEY);
$user_info = (new AdminModel())->getOneByCondition(['admin_id' => $uid]);

//$menu_info = (new MenuModel())->getMenuList(MenuModel::MENU_TYPE_BACKEND);

//$notice = (new Config())->getEnv('backend/notice.default');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="icon" href="<?=Url::to('@web/favicon.ico') ?>">
    <?php $this->head() ?>
</head>

<?php $this->beginBody() ?>
<body class="main_body">
<div class="layui-layout layui-layout-admin">
    <!-- 顶部 -->
    <div class="layui-header header">
        <div class="layui-main">
            <a href="#" class="logo">简 默 后台管理系统</a>

            <a href="javascript:;" class="hideMenu icon-menu1 iconfont"></a>

            <!-- 搜索 -->
            <div class="layui-form component">
                <select name="modules" lay-verify="required" lay-search="">
                    <option value="">直接选择或搜索选择</option>
                </select>
                <i class="layui-icon">&#xe615;</i>
            </div>

            <!-- 顶部右侧菜单 -->
            <ul class="layui-nav top_menu">
                <li class="layui-nav-item showNotice" id="showNotice" pc>
                    <a href=""><i class="iconfont icon-gonggao"></i><cite>系统公告</cite></a>
                </li>
                <li class="layui-nav-item" pc>
                    <a href="javascript:;">
                        <img src="<?=Url::to($user_info['head']) ?>" class="layui-circle" width="35" height="35">
                        <cite><?=$user_info['username'] ?></cite>
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;" data-url="page/user/userInfo.html"><i class="iconfont icon-zhanghu" data-icon="icon-zhanghu"></i><cite>个人资料</cite></a></dd>
                        <dd><a href="javascript:;" data-url="page/user/changePwd.html"><i class="iconfont icon-shezhi1" data-icon="icon-shezhi1"></i><cite>修改密码</cite></a></dd>
                        <dd><a href="<?=Url::to(['site/logout']) ?>"><i class="iconfont icon-loginout"></i><cite>退出</cite></a></dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>
    <!-- 左侧导航 -->
    <div class="layui-side layui-bg-black">
        <div class="user-photo">
            <a class="img" title="我的头像" ><img src="<?=Url::to($user_info['head']) ?>"></a>
            <p>你好！<span class="userName"><?=$user_info['real_name'] ?></span>, 欢迎</p>
        </div>
        <br>
        <div class="navBar layui-side-scroll">
            <ul class="layui-nav layui-nav-tree">
                <li class="layui-nav-item">
                    <a href="<?=Url::to(['site/index']) ?>"><i class="iconfont icon-computer" data-icon="icon-computer"></i><cite>后台首页</cite></a>
                </li>
                <li class="layui-nav-item">
                    <a href="<?=Url::to(['user/index']) ?>"><i class="iconfont icon-computer" data-icon="icon-computer"></i><cite>用户管理</cite></a>
                </li>
                <!-- 不要循环输出了 -->
                <li class="layui-nav-item">
                    <a href="<?=Url::to(['menu/index']) ?>"><i class="iconfont icon-computer" data-icon="icon-computer"></i><cite>菜单管理</cite></a>
                </li>
                <li class="layui-nav-item">
                    <a href="<?=Url::to(['suggest/index']) ?>"><i class="iconfont icon-computer" data-icon="icon-computer"></i><cite>留言管理</cite></a>
                </li>
                <li class="layui-nav-item">
                    <a href="<?=Url::to(['banner/index']) ?>"><i class="iconfont icon-computer" data-icon="icon-computer"></i><cite>运营位管理</cite></a>
                </li>
                <li class="layui-nav-item layui-nav-itemed">
                    <a>
                        <i class="iconfont icon-text" data-icon="icon-text"></i>
                        <cite>公众号管理</cite>
                        <span class="layui-nav-more"></span>
                    </a>
                    <dl class="layui-nav-child">
                        <dd>
                            <a href="<?=Url::to(['wx/index']) ?>"><i class="iconfont" data-icon=""></i><cite>消息管理</cite></a>
                        </dd>
                        <dd>
                            <a href="<?=Url::to(['wx/user']) ?>"><i class="iconfont" data-icon=""></i><cite>用户管理</cite></a>
                        </dd>
                        <dd>
                            <a href="<?=Url::to(['wx/rules']) ?>"><i class="iconfont" data-icon=""></i><cite>规则管理</cite></a>
                        </dd>
                    </dl>
                </li>
                <li class="layui-nav-item layui-nav-itemed">
                    <a>
                        <i class="iconfont icon-text" data-icon="icon-text"></i>
                        <cite>文章管理</cite>
                        <span class="layui-nav-more"></span>
                    </a>
                    <dl class="layui-nav-child">
                        <dd>
                            <a href="<?=Url::to(['article/index']) ?>"><i class="iconfont" data-icon=""></i><cite>待审核文章</cite></a>
                        </dd>
                        <dd>
                            <a href="<?=Url::to(['article/index']) ?>"><i class="iconfont" data-icon=""></i><cite>已发布文章</cite></a>
                        </dd>
                        <dd>
                            <a href="<?=Url::to(['article/index']) ?>"><i class="iconfont" data-icon=""></i><cite>新增文章</cite></a>
                        </dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>
    <!-- 右侧内容 -->
    <?= $content ?>


    <!-- 底部 -->
<div class="layui-footer footer">
    <p>Copyright © <script>document.write(new Date().getFullYear());</script>.JZC All rights reserved.</p>
</div>
<!-- 移动导航 -->
<div class="site-tree-mobile layui-hide"><i class="layui-icon">&#xe602;</i></div>
<div class="site-mobile-shade"></div>

    <script>

    </script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
