<?php
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\Html;

$this->registerJsFile('@web/js/idnex-list.js', ['depends' => 'yii\web\JqueryAsset']);
?>
<?=Breadcrumbs::widget([
    'homeLink' => ['label' =>'首页'],
    'links' => [
        ['label' => '用户列表', 'url' => ['index']],
    ]
]) ?>
<div class="inner-container">
    <?php if (Yii::$app->session->hasFlash('success')){ ?>
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <?=Yii::$app->session->getFlash('success') ?>
    </div>
    <?php } ?>
    <?php if (Yii::$app->session->hasFlash('error')){ ?>
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <?=Yii::$app->session->getFlash('error') ?>
    </div>
    <?php } ?>
    <p class="text-right">
        <a class="btn btn-primary btn-middle" href="<?=Url::to(['user/add']) ?>">添加</a>
        <a id="delete-btn" class="btn btn-primary btn-middle">删除</a>
    </p>
    <?=Html::beginForm(['delete'], 'post', ['id' => 'dltForm']) ?>
        <table class="table table-hover">
            <thead>
            <tr>
                <th class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked',this.checked);"></th>
                <th>用户名</th>
                <th>登录IP</th>
                <th>登录时间</th>
                <th>创建时间</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($result as $_result): ?>
            <tr>
                <td class="text-center"><input type="checkbox" name="selected[]" value="<?=$_result['id'] ?>"></td>
                <td><?= $_result['username'] ?></td>
                <td><?= $_result['login_ip'] ?></td>
                <td><?= date('Y-m-d H:i:s', $_result['login_date']) ?></td>
                <td><?= date('Y-m-d H:i:s', $_result['date']) ?></td>
                <td><?= $_result['status'] == 1 ? '开启' : '禁用' ?></td>
                <td><a href="<?=Url::to(['edit', 'id' => $_result['id']]) ?>" title="编辑" class="data_op data_edit"></a> | <a href="javascript:void(0);" title="删除" class="data_op data_delete"></a></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </form>
    <?=Html::endForm() ?>
    <?= LinkPager::widget([
            'pagination' => $pagination
    ]) ?>

</div>

