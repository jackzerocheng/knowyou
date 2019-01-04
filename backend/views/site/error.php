<?php
use yii\helpers\Url;
?>

<div class="layui-body layui-form">
    <div class="layui-tab marg0" lay-filter="bodyTab" id="top_tabs_box">
        <ul class="layui-tab-title top_tab" id="top_tabs">
            <li class="layui-this" lay-id=""><i class="iconfont icon-computer"></i> <cite>出错了</cite></li>
        </ul>
        <ul class="layui-nav closeBox">
            <li class="layui-nav-item">
                <a href="javascript:;"><i class="iconfont icon-caozuo"></i> 页面操作</a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;" class="refresh refreshThis"><i class="layui-icon">&#x1002;</i> 刷新当前</a></dd>
                    <dd><a href="javascript:;" class="closePageOther"><i class="iconfont icon-prohibit"></i> 关闭其他</a></dd>
                    <dd><a href="javascript:;" class="closePageAll"><i class="iconfont icon-guanbi"></i> 关闭全部</a></dd>
                </dl>
            </li>
        </ul>
        <div class="layui-tab-content clildFrame">

            <div style="text-align: center; padding:11% 0;">
                <i class="layui-icon" style="line-height:20rem; font-size:20rem; color: #393D50;">&#xe61c;</i>
                <p style="font-size: 20px; font-weight: 300; color: #999;">我勒个去，页面被外星人挟持了!
                    <a href="<?=Url::to(['site/index']) ?>" style="color:blue">返回首页</a></p>
                <p style="font-size: 20px; font-weight: 300; color: red;"><?=Yii::$app->session->getFlash('error_message') ?></p>
            </div>

        </div>
    </div>
</div>