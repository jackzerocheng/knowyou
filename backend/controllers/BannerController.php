<?php
/**
 * Message: 运营位管理
 * User: jzc
 * Date: 2019/3/20
 * Time: 2:38 PM
 * Return:
 */

namespace backend\controllers;

use common\models\BannerModel;
use yii\data\Pagination;
use Yii;

class BannerController extends CommonController
{
    public $enableCsrfValidation = false;
    /*
     * 网站内运营位管理
     */
    public function actionIndex()
    {
        $bannerModel = new BannerModel();
        $condition = ['not_status' => $bannerModel::STATUS_DELETED];
        $count = $bannerModel->getCountByCondition($condition);
        $page = new Pagination(['totalCount' => $count, 'pageSize' => 10]);
        $bannerList = array();
        if ($count > 0) {
            $bannerList = $bannerModel->getListByCondition($condition, $page->limit, $page->offset, 'type');
        }

        $data = [
            'data' => $bannerList,
            'pages' => $page,
            'platform_map' => $bannerModel->platformMap,
            'type_map' => $bannerModel->bannerTypeMap,

        ];
        return $this->render('index', $data);
    }

    /*
     * 添加运营位
     */
    public function actionAdd()
    {
        $bannerModel = new BannerModel();
        $data = [
            'type_map' => $bannerModel->bannerTypeMap,
            'status_map' => $bannerModel->bannerStatusMap
        ];
        return $this->renderPartial('add', $data);
    }

    public function actionInsert()
    {
        $data = Yii::$app->request->post();
        if (empty($data)) {
            Yii::$app->session->setFlash('error_message', '数据错误');
            return $this->redirect(['site/error']);
        }

        $bannerModel = new BannerModel();
        $rs = $bannerModel->insert($data);
        if ($rs) {
            Yii::$app->session->setFlash('banner_message','添加运营位成功');
            return $this->redirect(['site/close']);
        }

        Yii::$app->session->setFlash('edit_banner_message', '添加运营位失败');
        return $this->redirect(['banner/add']);
    }

    /*
     * 编辑运营位
     */
    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        $bannerModel = new BannerModel();
        if (empty($id) || empty($bannerInfo = $bannerModel->getOneByCondition(['id' => $id]))) {
            Yii::$app->session->setFlash('error_message', '数据错误');
            return $this->redirect(['site/error']);
        }

        $data= [
            'data' => $bannerInfo,
            'type_map' => $bannerModel->bannerTypeMap,
            'status_map' => $bannerModel->bannerStatusMap
        ];
        return $this->renderPartial('edit', $data);
    }

    public function actionUpdate()
    {
        $data = Yii::$app->request->post();
        if (empty($data)) {
            Yii::$app->session->setFlash('error_message', '数据错误');
            return $this->redirect(['site/error']);
        }

        $bannerModel = new BannerModel();
        $rs = $bannerModel->update($data, ['id' => $data['id']]);
        if ($rs) {
            Yii::$app->session->setFlash('banner_message','编辑运营位成功');
            return $this->redirect(['site/close']);
        }

        Yii::$app->session->setFlash('banner_message', '编辑运营位失败');
        return $this->redirect(['site/close']);
    }
}