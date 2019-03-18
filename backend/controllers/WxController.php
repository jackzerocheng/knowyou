<?php
/**
 * Message: 微信服务后台管理
 * User: jzc
 * Date: 2019/2/27
 * Time: 1:56 PM
 * Return:
 */

namespace backend\controllers;

use common\models\WX\WxRecordModel;
use common\models\WX\WxRulesModel;
use common\models\WX\WxUserModel;
use yii\data\Pagination;
use Yii;

class WxController extends CommonController
{
    /*
     * 公众号消息记录列表页   -- 分页展示
     */
    public function actionIndex()
    {
        $recordModel = new WxRecordModel();

        //分页组件
        $count = $recordModel->getCountByCondition([]);
        $page = new Pagination(['totalCount' => $count, 'pageSize' => '10']);
        $recordList = array();
        if ($count > 0) {
            $recordList = $recordModel->getListByCondition([], $page->limit, $page->offset);
        }

        return $this->render('index', ['data' => $recordList, 'pages' => $page, 'type_map' => $recordModel->typeMap]);
    }

    /*
     * 用户列表
     */
    public function actionUser()
    {
        $wxUserModel = new WxUserModel();

        //分页
        $count = $wxUserModel->getCountByCondition([]);
        $page = new Pagination(['totalCount' => $count, 'pageSize' => '10']);
        $userList = array();
        if ($count > 0) {
            $userList = $wxUserModel->getListByCondition([], $page->limit, $page->offset);
        }

        return $this->render('user', ['data' => $userList, 'pages' => $page]);
    }

    /*
     * 规则列表
     */
    public function actionRules()
    {
        $rulesModel = new WxRulesModel();

        //分页组件
        $count = $rulesModel->getCountByCondition([]);
        $page = new Pagination(['totalCount' => $count, 'pageSize' => '10']);
        $rulesList = array();
        if ($count > 0) {
            $rulesList = $rulesModel->getListByCondition([], $page->limit, $page->offset);
        }

        return $this->render('rule', ['data' => $rulesList, 'pages' => $page]);
    }

    /*
     * 规则编辑页
     */
    public function actionRuleEdit()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            Yii::$app->session->setFlash('error_message', '异常操作编辑规则');
            return $this->redirect(['site/error']);
        }

        $ruleModel = new WxRulesModel();
        $ruleInfo = $ruleModel->getOneByCondition(['id' => $id]);
        if (empty($ruleInfo)) {
            Yii::$app->session->setFlash('rule_message', '规则信息不存在');
            return $this->redirect(['wx/rules']);
        }

        return $this->renderPartial('rule_edit', ['data' => $ruleInfo]);
    }
}