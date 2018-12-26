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

class MenuController extends CommonController
{
    public function actionIndex()
    {
        //前台菜单
        $menuModel = new MenuModel();
        $frontendMenuList = $menuModel->getMenuList($menuModel::MENU_TYPE_FRONTEND);

        $data = [
            'menu_list' => $frontendMenuList,
            'level_map' => $menuModel->menuLevelMap,
            'status_map' => $menuModel->menuStatusMap
        ];

        return $this->render('frontend', $data);
    }

    public function actionBackend()
    {
        return $this->render('backend');
    }

    public function actionAdd()
    {
        return $this->renderPartial('add');
    }
}