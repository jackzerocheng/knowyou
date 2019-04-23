<?php
/**
 * Message: 更新文章阅读数
 * User: jzc
 * Date: 2018/12/4
 * Time: 3:29 PM
 * Return:
 */

namespace console\controllers\crontab;

use common\models\ArticleModel;
use Yii;

class UpdateArticleReadNumberController extends BaseController
{
    public function actionIndex()
    {
        /*
         * 定时将Redis中阅读数更新到DB
         * 每十分钟一次
         */
        $key = ArticleModel::REDIS_ARTICLE_READ_NUMBER . date('Ymd');
        $redis = Yii::$app->redis;

        if (!$redis->exists($key)) {
            //Yii::error("error:cannot get redis read number key", CATEGORIES_CONSOLE);
            exit(1);
        }

        $data = $redis->hgetall($key);//获取脚本执行这一刻的全部数据并更新
        if (count($data) < 3) {
            Yii::warning("warning:donot have read number data", CATEGORIES_CONSOLE);
            exit(2);
        }

        Yii::info("info:update article read number run", CATEGORIES_CONSOLE);
        $order = array();
        /**
         * 先将同一个表的ID归到一个子数组中
         * 0和1为base_id占位
         */
        for($i = 2;$i < count($data);$i = $i + 2) {
            $part = $data[$i] % ArticleModel::TABLE_PARTITION;
            $order[$part][$data[$i]]['id'] = $data[$i];
            $order[$part][$data[$i]]['read_number'] = $data[$i + 1];
        }

        $count = 0;
        foreach ($order as $k => $line) {
            if (!empty($line)) {
                $rs = (new ArticleModel())->updateBatch($key, $line, 'id');
                if (!$rs) {
                    Yii::error("error:update read number to db failed!partition:{$k}", CATEGORIES_CONSOLE);
                }
                $count = $count + $rs;
            }
        }

        Yii::warning("warning:update all read number data;total:{$count}", CATEGORIES_CONSOLE);
    }
}