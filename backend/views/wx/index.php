<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>

<div class="layui-body layui-form">
    <div class="layui-tab marg0" lay-filter="bodyTab" id="top_tabs_box">
        <ul class="layui-tab-title top_tab" id="top_tabs">
            <li class="layui-this" lay-id=""><i class="iconfont icon-computer"></i> <cite>公众号留言列表</cite></li>
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
                            <col width="9%">
                            <col width="9%">
                            <col width="9%">
                            <col width="9%">
                            <col>
                            <col width="9%">
                            <col width="10%">
                        </colgroup>
                        <thead>
                        <tr>
                            <th style="text-align:left;">留言ID</th>
                            <th>消息ID</th>
                            <th>消息类型</th>
                            <th>发送人</th>
                            <th>消息内容</th>
                            <th>事件</th>
                            <th>发送时间</th>
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
                                    <td><?=$_record['msg_id'] ?></td>
                                    <td><?=$type_map[$_record['msg_type']] ?></td>
                                    <td><?=$_record['from_user_name'] ?></td>
                                    <td><?=$_record['content'] ?></td>
                                    <td><?=$_record['event'] ?></td>
                                    <td><?=$_record['created_at'] ?></td>
                                    <td>
                                        <a class="layui-btn layui-btn-mini news_edit" href="#"><i class="layui-icon">&#xe618;</i>通过</a>
                                        <a class="layui-btn layui-btn-danger layui-btn-mini" href="#"><i class="layui-icon">&#x1006;</i>拒绝</a>
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