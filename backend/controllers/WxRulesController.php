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

        $rs = $rulesModel->update(['status' => $rulesModel::STATUS_DELETED], ['id' => $id]);
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
     * 编辑规则
     */
    public function actionUpdate()
    {
        $data = Yii::$app->request->post();
        if (empty($data['id'])) {
            Yii::$app->session->setFlash('error_message', '数据错误');
            return $this->redirect(['site/error']);
        }

        $ruleModel = new WxRulesModel();
        //$check = $ruleModel->checkData($data);
        $rs = $ruleModel->update($data, ['id' => $data['id']]);
        if ($rs) {
            Yii::$app->session->setFlash('rule_message', '编辑规则成功');
            return $this->redirect(['site/close']);
        }

        return $this->redirect(['wx/rule-edit']);
    }

    /*
     * 添加规则
     */
    public function actionInsert()
    {
        $data = Yii::$app->request->post();
        //var_dump($data);die;
        $ruleModel = new WxRulesModel();
        $check = $ruleModel->checkData($data);
        if ($check) {
            $rs = $ruleModel->insert($data);
            if ($rs) {
                Yii::$app->session->setFlash('rule_message', '添加规则成功');
                return $this->redirect(['site/close']);
            }
        }

        return $this->redirect(['wx/rule-add']);
    }
}