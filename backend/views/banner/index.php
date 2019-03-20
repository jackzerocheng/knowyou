<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>

<div class="layui-body layui-form">
    <div class="layui-tab marg0" lay-filter="bodyTab" id="top_tabs_box">
        <ul class="layui-tab-title top_tab" id="top_tabs">
            <li class="layui-this" lay-id=""><i class="iconfont icon-computer"></i> <cite>运营位管理</cite></li>
        </ul>
        <ul class="layui-nav closeBox">
            <li class="layui-nav-item">
            </li>
        </ul>
        <div class="layui-tab-content clildFrame">

            <div class="layui-tab-item layui-show internal-container">
                <blockquote class="layui-elem-quote news_search">
                    <div class="layui-inline">
                        <a class="layui-btn layui-btn-normal banner_add">添加运营位</a>
                    </div>
                    <div class="layui-inline">
                        <p style="color:red"><?=Yii::$app->session->getFlash('banner_message') ?></p>
                    </div>
                </blockquote>
                <div class="layui-form news_list">
                    <table class="layui-table">
                        <thead>
                        <tr>
                            <th style="text-align:left;">运营位ID</th>
                            <th width="50px">平台</th>
                            <th>名称</th>
                            <th>图片链接</th>
                            <th>跳转地址</th>
                            <th>状态</th>
                            <th>类型</th>
                            <th>开始时间</th>
                            <th>结束时间</th>
                            <th>创建时间</th>
                            <th>更新时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody class="news_content">
                        <?php

                        if (!empty($data)) {
                            foreach ($data as $_banner) {
                                ?>

                                <tr>
                                    <td align="left"><?=$_banner['id'] ?></td>
                                    <td><?=$_banner['platform_msg'] ?></td>
                                    <td><?=$_banner['name'] ?></td>
                                    <td><?=$_banner['img'] ?></td>
                                    <td><?=$_banner['link'] ?></td>
                                    <td>
                                        <?php
                                            if ($_banner['status_msg'] == '投放中') {
                                                echo "<p style='color: green'>{$_banner['status_msg']}</p>";
                                            } else {
                                                echo "<p style='color: red'>{$_banner['status_msg']}</p>";
                                            }
                                        ?>
                                    </td>
                                    <td><?=$_banner['type_msg'] ?></td>
                                    <td><?=$_banner['start_at'] ?></td>
                                    <td><?=$_banner['end_at'] ?></td>
                                    <td><?=$_banner['created_at'] ?></td>
                                    <td><?=$_banner['updated_at'] ?></td>
                                    <td>
                                        <a class="layui-btn layui-btn-mini banner_edit" data-id="<?=$_banner['id'] ?>"><i class="layui-icon">&#xe618;</i>编辑</a>
                                        <a class="layui-btn layui-btn-danger layui-btn-mini" href="<?=Url::to(['banner/delete', 'id' => $_banner['id']]) ?>"><i class="layui-icon">&#x1006;</i>删除</a>
                                    </td>
                                </tr>

                                <?php
                            }
                        }

                        ?>
                        </tbody>
                    </table>
                </div>
                <div>
                    <?=LinkPager::widget(['pagination' => $pages]) ?>
                </div>
                <div id="page"></div>
            </div>

        </div>
    </div>
</div>