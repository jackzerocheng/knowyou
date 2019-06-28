<?php
/**
 * Message: 留言
 * User: jzc
 * Date: 2019/6/27
 * Time: 9:48 PM
 * Return:
 */

namespace frontend\actions\Contact;


use common\models\SuggestModel;
use frontend\actions\BaseAction;
use Yii;

class ReplyAction extends BaseAction
{
    /**
     * 记录回复
     */
    public function run()
    {
        $data = Yii::$app->request->post();

        if (empty($data['name']) || empty($data['email']) || empty($data['message'])) {
            $this->outputJson('params_error');
        }

        $info = [
            'name' => $data['name'],
            'email' => $data['email'],
            'content' => $data['message']
        ];
        $suggestModel = new SuggestModel();
        $rs = $suggestModel->insert($info);

        if (!$rs) {
            $this->outputJson('reply_suggestion_fail');
        }

        $this->success();
    }
}