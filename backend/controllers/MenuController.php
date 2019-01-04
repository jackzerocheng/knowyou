<?php
/**
 * Message: 菜单控制
 * User: jzc
 * Date: 2018/12/26
 * Time: 10:34 AM
 * Return:
 */

namespace backend\controllers;

use common\models\MenuModel;
use Yii;

class MenuController extends CommonController
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        //前台菜单
        $menuModel = new MenuModel();
        $frontendMenuList = $menuModel->getMenuList($menuModel::MENU_TYPE_FRONTEND, true);

        $data = [
            'menu_list' => $frontendMenuList,
            'level_map' => $menuModel->menuLevelMap,
            'status_map' => $menuModel->menuStatusMap
        ];

        return $this->render('frontend', $data);
    }

    public function actionBackend()
    {
        //TODO 权限控制

        //前台菜单
        $menuModel = new MenuModel();
        $backendMenuList = $menuModel->getMenuList($menuModel::MENU_TYPE_BACKEND, true);

        $data = [
            'menu_list' => $backendMenuList,
            'level_map' => $menuModel->menuLevelMap,
            'status_map' => $menuModel->menuStatusMap
        ];

        return $this->render('backend', $data);
    }

    //添加页 + insert操作
    public function actionAdd()
    {
        $menuModel = new MenuModel();
        $type = Yii::$app->request->get('type');
        if (!$type) {
            Yii::info("illegal enter to add menu page without type;", CATEGORIES_INFO);
            return $this->redirect(['site/error']);
        }

        $data = [
            'type' => $type,
            'level_map' => $menuModel->menuLevelMap,
            'parent_menu' => $menuModel->getListByCondition(['level' => $menuModel::MENU_LEVEL_FIRST, 'type' => $type]),
        ];
        return $this->renderPartial('add', $data);
    }

    //insert操作
    public function actionInsert()
    {
        $menuModel = new MenuModel();
        $data = Yii::$app->request->post();
        $checked = $menuModel->checkData($data);//检查数据，出错会设置flash提示
        if ($checked) {
            $rs = $menuModel->insert($data);
            if ($rs) {
                Yii::info('add menu;data:'.json_encode($data).';uid:'.$this->uid, CATEGORIES_INFO);
                Yii::$app->session->setFlash('message', '添加菜单成功');
                return true;
            }
            Yii::$app->session->setFlash('message', '菜单添加失败');
            Yii::warning("insert data into menu failed!data:".json_encode($data), CATEGORIES_WARN);
            return false;
        }

        return false;
    }

    //编辑页
    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            Yii::info("illegal enter to edit menu page without id;", CATEGORIES_INFO);
            return $this->redirect(['site/error']);
        }

        $menuModel = new MenuModel();
        $menuInfo = $menuModel->getOneByCondition(['id' => $id]);
        $parentList = $menuModel->getListByCondition(['type' => $menuInfo['type']]);

        $data = [
            'menu_info' => $menuInfo,
            'level_map' => $menuModel->menuLevelMap,
            'parent_list' => $parentList,
            'status_map' => $menuModel->menuStatusMap

        ];
        return $this->renderPartial('edit', $data);
    }

    //update操作
    public function actionUpdate()
    {
        $menuModel = new MenuModel();
        $data = Yii::$app->request->post();
        $checked = $menuModel->checkData($data);
        if ($checked) {
            $rs = $menuModel->update($data, ['id' => $data['id']]);
            if ($rs) {
                Yii::info('update menu;data:'.json_encode($data).';uid:'.$this->uid, CATEGORIES_INFO);
                Yii::$app->session->setFlash('message', '更新菜单成功');
                return true;
            }
            Yii::$app->session->setFlash('message', '菜单更新失败');
            Yii::warning('update menu info failed;data:'.json_encode($data), CATEGORIES_WARN);
            return false;
        }

        return false;
    }

    //delete操作
    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');
        if (empty($id)) {
            Yii::$app->session->setFlash('message', '异常操作删除菜单');
            return $this->redirect(['site/error']);
        }

        $menuModel = new MenuModel();
        $menuInfo = $menuModel->getOneByCondition(['id' => $id]);
        if ($menuInfo['type'] == $menuModel::MENU_TYPE_FRONTEND) {
            $path = 'menu/index';
        } elseif ($menuInfo['type'] == $menuModel::MENU_TYPE_BACKEND) {
            $path = 'menu/backend';
        }

        if ($menuInfo['status'] == $menuModel::MENU_STATUS_USING) {
            Yii::$app->session->setFlash('message', '无法删除展示中的菜单');
            return $this->redirect([$path]);
        }

        //$rs = $menuModel->delete(['id' => $id]);
        $rs = $menuModel->update(['status' => $menuModel::MENU_STATUS_DELETED], ['id' => $id]);
        if (!$rs) {
            Yii::warning('delete menu info failed!id:'.$id, CATEGORIES_WARN);
            Yii::$app->session->setFlash('message', '删除菜单失败');
            return $this->redirect([$path]);
        }

        Yii::info('delete menu info success;id:'.$id.';uid:'.$this->uid, CATEGORIES_INFO);
        Yii::$app->session->setFlash('message', '删除菜单成功');
        return $this->redirect([$path]);
    }
}