<?php
/*
 * 定时任务配置文件, 格式: 启动时间 脚本类型 脚本路径 进程数 版本号
 *
 * 启动时间格式与Linux Crotab 格式一致: 分 时 日 月 周
 *
 * 版本号可以用任意数字串表示, 不能包含除了数字和点之外的其他字符.
 *
 * 以下操作会导致某个进程重启:
 *
 * 1. 修改某个任务的版本号.
 * 2. 修改某个任务的进程数.
 *
 * eg:php yii script/crontab
 */

return array(
    //'0 1 * * * php /credit_card/clean_dirty_apply_data 1 1.0',

    "1 * * * * /usr/local/php/bin/php /var/www/html/knowyou/yii /crontab/test-code/index 1 1.0"
);