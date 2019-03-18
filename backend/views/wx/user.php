<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>

<div class="layui-body layui-form">
    <div class="layui-tab marg0" lay-filter="bodyTab" id="top_tabs_box">
        <ul class="layui-tab-title top_tab" id="top_tabs">
            <li class="layui-this" lay-id=""><i class="iconfont icon-computer"></i> <cite>用户管理</cite></li>
        </ul>
        <ul class="layui-nav closeBox">
            <li class="layui-nav-item">
            </li>
        </ul>
        <div class="layui-tab-content clildFrame">

            <div class="layui-tab-item layui-show internal-container">
                <blockquote class="layui-elem-quote news_search">

                </blockquote>
                <div class="layui-form news_list">
                    <table class="layui-table">
                        <colgroup>
                            <col>
                            <col>
                            <col>
                            <col>
                            <col>
                            <col>
                            <col>
                        </colgroup>
                        <thead>
                        <tr>
                            <th style="text-align:left;">用户ID</th>
                            <th>openID</th>
                            <th>状态</th>
                            <th>创建时间</th>
                            <th>更新时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody class="news_content">
                        <?php

                        if (!empty($data)) {
                            foreach ($data as $_record) {
                                ?>

                                <tr>
                                    <td align="left"><?=$_record['id'] ?></td>
                                    <td><?=$_record['open_id'] ?></td>
                                    <td><?=$_record['status_msg'] ?></td>
                                    <td><?=$_record['created_at'] ?></td>
                                    <td><?=$_record['updated_at'] ?></td>
                                    <td>
                                        <a class="layui-btn layui-btn-mini news_edit" href="#"><i class="layui-icon">&#xe618;</i>xx</a>
                                        <a class="layui-btn layui-btn-danger layui-btn-mini" href="#"><i class="layui-icon">&#x1006;</i>xx</a>
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