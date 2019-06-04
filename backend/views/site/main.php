<?php
use yii\helpers\Url;
?>

<div class="layui-body layui-form">
    <div class="layui-tab marg0" lay-filter="bodyTab" id="top_tabs_box">
        <ul class="layui-tab-title top_tab" id="top_tabs">
            <li class="layui-this" lay-id=""><i class="iconfont icon-computer"></i> <cite>后台首页</cite></li>
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

            <div class="layui-tab-item layui-show internal-container">
                <div class="panel_box row">
                    <div class="panel col">
                        <a href="<?=Url::toRoute(['suggest/index']) ?>">
                            <div class="panel_icon">
                                <i class="layui-icon" data-icon="&#xe63a;">&#xe63a;</i>
                            </div>
                            <div class="panel_word">
                                <span><?=$count_number['today_message_number'] ?></span>
                                <cite>今日留言</cite>
                            </div>
                        </a>
                    </div>
                    <div class="panel col">
                        <a href="<?=Url::toRoute(['user/index']) ?>">
                            <div class="panel_icon" style="background-color:#FF5722;">
                                <i class="iconfont icon-dongtaifensishu" data-icon="icon-dongtaifensishu"></i>
                            </div>
                            <div class="panel_word">
                                <span><?=$count_number['today_new_user_number'] ?></span>
                                <cite>今日注册用户</cite>
                            </div>
                        </a>
                    </div>
                    <div class="panel col">
                        <a href="<?=Url::toRoute(['user/index']) ?>">
                            <div class="panel_icon" style="background-color:#009688;">
                                <i class="layui-icon" data-icon="&#xe613;">&#xe613;</i>
                            </div>
                            <div class="panel_word">
                                <span><?=$count_number['all_user_number'] ?></span>
                                <cite>用户总数</cite>
                            </div>
                        </a>
                    </div>
                    <div class="panel col">
                        <a href="<?=Url::toRoute(['article/index']) ?>">
                            <div class="panel_icon" style="background-color:#F7B824;">
                                <i class="iconfont icon-wenben" data-icon="icon-wenben"></i>
                            </div>
                            <div class="panel_word">
                                <span><?=$count_number['today_article_number'] ?></span>
                                <cite>今日文章</cite>
                            </div>
                        </a>
                    </div>
                    <div class="panel col max_panel">
                        <a href="<?=Url::toRoute(['article/index']) ?>">
                            <div class="panel_icon" style="background-color:#2F4056;">
                                <i class="iconfont icon-text" data-icon="icon-text"></i>
                            </div>
                            <div class="panel_word">
                                <span><?=$count_number['all_article_number'] ?></span>
                                <cite>文章总数</cite>
                            </div>
                        </a>
                    </div>
                </div>
                <blockquote class="layui-elem-quote explain">
                    <p>后台功能</p>
                    <p>注意事项</p>
                </blockquote>
                <div class="row">
                    <div class="sysNotice col">
                        <blockquote class="layui-elem-quote title">最新留言</blockquote>
                        <table class="layui-table" lay-skin="line">
                            <colgroup>
                                <col>
                                <col width="110">
                            </colgroup>
                            <tbody class="hot_news">
                            <tr>
                                <td align="left"><a href="#">帅逼的修炼之路</a></td>
                                <td>2018-12-12</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="sysNotice col">
                        <blockquote class="layui-elem-quote title">最新文章<i class="iconfont icon-new1"></i></blockquote>
                        <table class="layui-table" lay-skin="line">
                            <colgroup>
                                <col>
                                <col width="110">
                            </colgroup>
                            <tbody class="hot_news">
                            <tr>
                                <td align="left">帅逼的修炼之路</td>
                                <td>2018-12-12</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
