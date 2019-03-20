<?php
use yii\helpers\Url;
?>
<script src="<?=Url::to('@web/layui/layui.js') ?>"></script>
<script>
    layui.use(['layer'], function(){
        var layer = layui.layer;
        //var $ = layui.jquery;
        //layer.msg('Hello World');
        //layer.closeAll('iframe');
        var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
        parent.layer.close(index); //再执行关闭
    })
</script>