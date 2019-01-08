<?php
use yii\helpers\Url;
?>

<div class="layui-body layui-form">
    <div class="layui-tab marg0" lay-filter="bodyTab" id="top_tabs_box">
        <ul class="layui-tab-title top_tab" id="top_tabs">
            <li class="layui-this" lay-id=""><i class="iconfont icon-computer"></i> <cite>待审核文章列表</cite></li>
        </ul>
        <ul class="layui-nav closeBox">
            <li class="layui-nav-item">
            </li>
        </ul>
        <div class="layui-tab-content clildFrame">

            <div class="layui-tab-item layui-show internal-container">
                <blockquote class="layui-elem-quote news_search">
                    <div class="layui-inline">
                        <div class="layui-input-inline">
                            <input type="text" value="" placeholder="请输入关键字" class="layui-input search_input">
                        </div>
                        <a class="layui-btn search_btn">查询</a>
                    </div>
                    <div class="layui-inline">
                        <a class="layui-btn layui-btn-normal newsAdd_btn">添加文章</a>
                    </div>
                    <div class="layui-inline">
                        <a class="layui-btn recommend" style="background-color:#5FB878">推荐文章</a>
                    </div>
                    <div class="layui-inline">
                        <a class="layui-btn audit_btn">审核文章</a>
                    </div>
                    <div class="layui-inline">
                        <a class="layui-btn layui-btn-danger batchDel">批量删除</a>
                    </div>
                    <div class="layui-inline">
                        <div class="layui-form-mid layui-word-aux">本页面刷新后除新添加的文章外所有操作无效，关闭页面所有数据重置</div>
                    </div>
                </blockquote>
                <div class="layui-form news_list">
                    <table class="layui-table">
                        <colgroup>
                            <col width="50">
                            <col width="9%">
                            <col width="9%">
                            <col width="9%">
                            <col width="9%">
                            <col width="9%">
                            <col>
                            <col>
                            <col width="9%">
                            <col width="9%">
                            <col width="9%">
                            <col width="10%">
                        </colgroup>
                        <thead>
                        <tr>
                            <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" id="allChoose"></th>
                            <th style="text-align:left;">文章标题</th>
                            <th>作者</th>
                            <th>封面</th>
                            <th>是否转载</th>
                            <th>状态</th>
                            <th>阅读数</th>
                            <th>点赞数</th>
                            <th>标签</th>
                            <th>上传时间</th>
                            <th>更新时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody class="news_content">
                        <?php

                        if (!empty($article_list)) {
                            foreach ($article_list as $article) {
                                ?>

                                <tr>
                                    <td><input type="checkbox" name="checked" lay-skin="primary" lay-filter="choose"></td>
                                    <td align="left"><?=$article['title'] ?></td>
                                    <td><?=$user_info[$article['uid']]['username'] ?></td>
                                    <td><img src="<?=Url::to($article['cover']) ?>"></td>
                                    <td><?php
                                        if($article['forward_id']){
                                            echo "<a href='#'>是</a>";
                                        }else{
                                            echo "<a style='color:green;'>否</a>";
                                        } ?></td>
                                    <td><?=$article_status_map[$article['status']] ?></td>
                                    <td><?=$article['redis_read_number'] ?></td>
                                    <td><?=$article['praise_number'] ?></td>
                                    <td><?=$tag_map[$article['tag']]['name'] ?></td>
                                    <td><?=$article['created_at'] ?></td>
                                    <td><?=$article['updated_at'] ?></td>
                                    <td>
                                        <a class="layui-btn layui-btn-mini news_edit"><i class="iconfont icon-edit"></i>通过</a>
                                        <a class="layui-btn layui-btn-normal layui-btn-mini news_collect"><i class="layui-icon">&#xe600;</i>拒绝</a>
                                        <a class="layui-btn layui-btn-danger layui-btn-mini news_del" data-id="'+data[i].newsId+'"><i class="layui-icon">&#xe640;</i> 封禁用户</a>
                                    </td>
                                </tr>

                                <?php
                            }
                        }

                        ?>
                        </tbody>
                    </table>
                </div>
                <div id="page"></div>
            </div>

        </div>
    </div>
</div>