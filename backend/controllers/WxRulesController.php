<?php
/**
 * Message: 微信规则 - 操作类
 * User: jzc
 * Date: 2019/3/1
 * Time: 10:49 AM
 * Return:
 */

namespace backend\controllers;

use common\models\WX\WxRulesModel;
use Yii;

class WxRulesController extends CommonController
{
    public $enableCsrfValidation = false;

    /*
     * 规则删除
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            Yii::$app->session->setFlash('error_message', '异常操作删除规则');
            return $this->redirect(['site/error']);
        }

        $rulesModel = new WxRulesModel();
        $rulesInfo = $rulesModel->getOneByCondition(['id' => $id]);
        if (empty($rulesInfo)) {
            Yii::$app->session->setFlash('rule_message', '规则信息不存在');
            return $this->redirect(['wx/rules']);
        }

        $rs = $rulesModel->update(['status' => $rulesModel::STATUS_DELETED]);
        if (!$rs) {
            Yii::warning("delete rule info failed;id:".$id, CATEGORIES_WARN);
            Yii::$app->session->setFlash('rule_message', '删除规则失败');
            return $this->redirect(['wx/rules']);
        }

        Yii::info("delete rule info success;id:".$id, CATEGORIES_INFO);
        Yii::$app->session->setFlash('rule_message', '删除规则成功');
        return $this->redirect(['wx/rules']);
    }

    /*
     * 规则编辑
     */
    public function actionUpdate()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            Yii::$app->session->setFlash('error_message', '异常操作编辑规则');
            return $this->redirect(['site/error']);
        }

        $ruleModel = new WxRulesModel();
        $ruleInfo = $ruleModel->getOneByCondition(['id' => $id]);
        if (empty($rulesInfo)) {
            Yii::$app->session->setFlash('rule_message', '规则信息不存在');
            return $this->redirect(['wx/rules']);
        }


    }
}