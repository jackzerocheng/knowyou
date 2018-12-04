<?php
/**
 * Message:
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
            Yii::error("cannot get redis read number key", CATEGORIES_ERROR);
            exit(1);
        }

        $data = $redis->hgetall($key);//获取脚本执行这一刻的全部数据并更新
        if (count($data) < 3) {
            Yii::warning("donot have read number data", CATEGORIES_WARN);
            exit(2);
        }

        Yii::info("update article read number run", CATEGORIES_INFO);
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
                $rs = (new ArticleModel($k))->updateBatch($line, 'id');
                if (!$rs) {
                    Yii::error("update read number to db failed!partition:{$k}", CATEGORIES_ERROR);
                }
                $count = $count + $rs;
            }
        }

        Yii::warning("update all read number data;total:{$count}", CATEGORIES_WARN);
    }
}