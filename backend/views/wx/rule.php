<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>

<div class="layui-body layui-form">
    <div class="layui-tab marg0" lay-filter="bodyTab" id="top_tabs_box">
        <ul class="layui-tab-title top_tab" id="top_tabs">
            <li class="layui-this" lay-id=""><i class="iconfont icon-computer"></i> <cite>规则列表</cite></li>
        </ul>
        <ul class="layui-nav closeBox">
            <li class="layui-nav-item">
            </li>
        </ul>
        <div class="layui-tab-content clildFrame">

            <div class="layui-tab-item layui-show internal-container">
                <blockquote class="layui-elem-quote news_search">
                    <div class="layui-inline">
                        <a class="layui-btn layui-btn-normal rule_add">添加规则</a>
                    </div>
                    <div class="layui-inline">
                        <p style="color:red"><?=Yii::$app->session->getFlash('rule_message') ?></p>
                    </div>
                </blockquote>
                <div class="layui-form news_list">
                    <table class="layui-table">
                        <colgroup>
                            <col width="">
                            <col width="">
                            <col width="">
                            <col width="">
                            <col>
                            <col width="">
                            <col width="">
                        </colgroup>
                        <thead>
                        <tr>
                            <th style="text-align:left;">规则ID</th>
                            <th>关键词</th>
                            <th>目标词</th>
                            <th>状态</th>
                            <th>类型</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody class="news_content">
                        <?php

                        if (!empty($data)) {
                            foreach ($data as $_rule) {
                                ?>

                                <tr>
                                    <td align="left"><?=$_rule['id'] ?></td>
                                    <td><?=$_rule['key_word'] ?></td>
                                    <td><?=$_rule['to_word'] ?></td>
                                    <td><?php
                                        if ($_rule['status'] == \common\models\WX\WxRulesModel::STATUS_OPEN) {
                                            echo "<p style='color: green'>".$_rule['status_msg']."</p>";
                                        } elseif ($_rule['status'] == \common\models\WX\WxRulesModel::STATUS_CLOSED) {
                                            echo "<p style='color: grey'>".$_rule['status_msg']."</p>";
                                        } elseif ($_rule['status'] == \common\models\WX\WxRulesModel::STATUS_DELETED) {
                                            echo "<p style='color: red'>".$_rule['status_msg']."</p>";
                                        }
                                        ?></td>
                                    <td><?=$_rule['type_msg'] ?></td>
                                    <td><?=$_rule['created_at'] ?></td>
                                    <td>
                                        <a class="layui-btn layui-btn-mini rule_edit" data-id="<?=$_rule['id'] ?>"><i class="layui-icon">&#xe618;</i>编辑</a>
                                        <a class="layui-btn layui-btn-danger layui-btn-mini" href="<?=Url::to(['wx-rules/delete', 'id' => $_rule['id']]) ?>"><i class="layui-icon">&#x1006;</i>删除</a>
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