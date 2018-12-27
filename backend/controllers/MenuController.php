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
        //前台菜单
        $menuModel = new MenuModel();
        $backendMenuList = $menuModel->getMenuList($menuModel::MENU_TYPE_BACKEND);

        $data = [
            'menu_list' => $backendMenuList,
            'level_map' => $menuModel->menuLevelMap,
            'status_map' => $menuModel->menuStatusMap
        ];

        return $this->render('backend', $data);
    }


    public function actionAdd()
    {
        $menuModel = new MenuModel();
        $content = array();
        $type = 0;
        if (Yii::$app->request->isPost) {//提交信息
            $data = Yii::$app->request->post();
            $type= intval($data['type']);
            //菜单级别和父级菜单关系判断
            if (($data['level'] == $menuModel::MENU_LEVEL_FIRST && $data['parent_id'] != 0)
            || ($data['level'] == $menuModel::MENU_LEVEL_SECOND && $data['parent_id'] == 0)) {
                Yii::$app->session->setFlash('message', '一级菜单不能有父级菜单，二级菜单必须有父级菜单');
                $content = $data;
            } elseif (intval($data['weight']) < 0) {
                Yii::$app->session->setFlash('message', '权重不能为负值');
                $content = $data;
            } else {
                $rs = $menuModel->insert($data);
                if ($rs) {
                    Yii::info('add menu;data:'.json_encode($data).'uid:'.$this->uid, CATEGORIES_INFO);
                    return $this->redirect(['menu/list']);
                }

                Yii::$app->session->setFlash('message', '菜单添加失败');
                $content = $data;
            }
        }

        if (empty($type)) {//列表页跳转
            $type = Yii::$app->request->get('type');
            if (!$type) {
                Yii::info("illegal enter to add menu page without type;", CATEGORIES_INFO);
                return $this->redirect(['site/error']);
            }
        }

        $data = [
            'type' => $type,
            'level_map' => $menuModel->menuLevelMap,
            'parent_menu' => $menuModel->getListByCondition(['level' => $menuModel::MENU_LEVEL_FIRST, 'type' => $type]),
            'content' => $content
        ];
        return $this->renderPartial('add', $data);
    }

    public function actionEdit()
    {
        return $this->renderPartial('edit');
    }
}