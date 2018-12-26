<?php
use yii\helpers\Url;
?>

<div class="layui-body layui-form">
    <div class="layui-tab marg0" lay-filter="bodyTab" id="top_tabs_box">
        <ul class="layui-tab-title top_tab" id="top_tabs">
            <li class="layui-this" lay-id=""><i class="iconfont icon-computer"></i> <cite>前台菜单管理</cite></li>
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
                            <col>
                            <col width="9%">
                            <col width="9%">
                            <col width="9%">
                            <col width="9%">
                            <col width="9%">
                            <col width="15%">
                        </colgroup>
                        <thead>
                        <tr>
                            <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" id="allChoose"></th>
                            <th style="text-align:left;">文章标题</th>
                            <th>发布人</th>
                            <th>审核状态</th>
                            <th>浏览权限</th>
                            <th>是否展示</th>
                            <th>发布时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody class="news_content">
                        <tr>
                            <td><input type="checkbox" name="checked" lay-skin="primary" lay-filter="choose"></td>
                            <td align="left">成长之路</td>
                            <td>老刘</td>
                            <td style="color:#f00">待审核</td>
                            <td>开放浏览</td>
                            <td><input type="checkbox" name="show" lay-skin="switch" lay-text="是|否" lay-filter="isShow" checked></td>
                            <td>2018</td>
                            <td>
                                <a class="layui-btn layui-btn-mini news_edit"><i class="iconfont icon-edit"></i> 编辑</a>
                                <a class="layui-btn layui-btn-normal layui-btn-mini news_collect"><i class="layui-icon">&#xe600;</i> 收藏</a>
                                <a class="layui-btn layui-btn-danger layui-btn-mini news_del" data-id="'+data[i].newsId+'"><i class="layui-icon">&#xe640;</i> 删除</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div id="page"></div>
            </div>

        </div>
    </div>
</div>
