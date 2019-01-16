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
                </dl>
            </li>
        </ul>
        <div class="layui-tab-content clildFrame">

            <div class="layui-tab-item layui-show internal-container">
                <blockquote class="layui-elem-quote news_search">
                    <div class="layui-inline">
                        <a class="layui-btn layui-btn-normal frontendMenu_add">添加菜单</a>
                    </div>
                    <div class="layui-inline">
                        <div class="layui-form-mid layui-word-aux">添加菜单前请确认菜单路径存在</div>
                    </div>
                    <div class="layui-inline">
                        <p style="color:red"><?=Yii::$app->session->getFlash('front_message') ?></p>
                    </div>
                </blockquote>
                <div class="layui-form news_list">
                    <table class="layui-table">
                        <colgroup>
                            <col width="5%">
                            <col width="5%">
                            <col width="9%">
                            <col width="9%">
                            <col width="9%">
                            <col>
                            <col width="9%">
                            <col width="15%">
                        </colgroup>
                        <thead>
                        <tr>
                            <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" id="allChoose"></th>
                            <th>菜单ID</th>
                            <th>菜单名称</th>
                            <th>菜单类别</th>
                            <th>父级菜单</th>
                            <th>菜单链接</th>
                            <th>菜单权重(越小越靠前)</th>
                            <th>菜单状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody class="news_content">

                        <?php
                        if (!empty($menu_list)) {
                            foreach ($menu_list as $menu) {
                                //一级菜单
                        ?>
                            <tr>
                                <td><input type="checkbox" name="checked" lay-skin="primary" lay-filter="choose"></td>
                                <td align="left"><?=$menu['id'] ?></td>
                                <td><?=$menu['name'] ?></td>
                                <td><?=$level_map[$menu['level']] ?></td>
                                <td>无</td>
                                <td><a href="#" style="color:blue"><?=$menu['url'] ?></a></td>
                                <td><?=$menu['weight'] ?></td>
                                <td style="color: red;"><?=$status_map[$menu['status']] ?></td>
                                <td>
                                    <a class="layui-btn layui-btn-mini menu_edit" data-id="<?=$menu['id'] ?>"><i class="iconfont icon-edit"></i> 编辑</a>
                                    <?php
                                    if ($menu['status'] != 1) {
                                        echo "<a class=\"layui-btn layui-btn-danger layui-btn-mini\" href=\"".Url::to(['menu/delete','id' => $menu['id']]) ."\"><i class=\"layui-icon\">&#xe640;</i> 删除</a>";
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php
                            if (!empty($menu['child_menu'])) {
                                foreach ($menu['child_menu'] as $child_menu) {
                                    //二级菜单
                        ?>
                                    <tr>
                                        <td><input type="checkbox" name="checked" lay-skin="primary" lay-filter="choose"></td>
                                        <td align="left"><?=$child_menu['id'] ?></td>
                                        <td><?=$child_menu['name'] ?></td>
                                        <td><?=$level_map[$child_menu['level']] ?></td>
                                        <td><?=$menu['name'] ?></td>
                                        <td><a href="#" style="color:blue"><?=$child_menu['url'] ?></a></td>
                                        <td><?=$child_menu['weight'] ?></td>
                                        <td style="color: red;"><?=$status_map[$child_menu['status']] ?></td>
                                        <td>
                                            <a class="layui-btn layui-btn-mini menu_edit" data-id="<?=$child_menu['id'] ?>"><i class="iconfont icon-edit"></i> 编辑</a>
                                            <?php
                                            if ($child_menu['status'] == 1) {
                                                //echo "<a class=\"layui-btn layui-btn-danger layui-btn-mini\" href=\"#\"><i class=\"layui-icon\">&#xe640;</i> 删除</a>";
                                            } else {
                                                echo "<a class=\"layui-btn layui-btn-danger layui-btn-mini\" href=\"".Url::to(['menu/delete','id' => $child_menu['id']]) ."\"><i class=\"layui-icon\">&#xe640;</i> 删除</a>";
                                            }
                                            ?>

                                        </td>
                                    </tr>
                        <?php
                                }
                            }
                            }
                        } else {
                            echo "<tr><td colspan=\"9\">暂无数据</td></tr>";
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