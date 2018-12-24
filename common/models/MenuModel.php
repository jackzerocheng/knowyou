<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/10/25
 * Time: 5:33 PM
 * Return:
 */

namespace common\models;

use yii\base\Model;
use common\dao\Menu;

class MenuModel extends Model
{
    //菜单等级
    const MENU_LEVEL_FIRST = 1;//父级菜单
    const MENU_LEVEL_SECOND = 2;//二级子菜单

    //菜单状态
    const MENU_STATUS_USING = 1;
    const MENU_STATUS_STOP = 2;
    public $menuStatusMap = [
        self::MENU_STATUS_USING => '使用中',
        self::MENU_STATUS_STOP => '下架'
    ];

    const MENU_TYPE_FRONTEND = 1;//前台
    const MENU_TYPE_BACKEND = 2;//后台

    /**
     * 获取完整菜单
     * @param $type integer
     * @return array
     */
    public function getMenuList($type = 1)
    {
        $menuList = (new Menu())->getListByCondition(['status' => self::MENU_STATUS_USING, 'type' => $type]);

        if (empty($menuList)) {
            return array();
        }

        /**
         * 拆分一级菜单和二级菜单
         */
        foreach ($menuList as $_menu) {
            if ($_menu['level'] == self::MENU_LEVEL_FIRST) {
                $menu_first[] = $_menu;
            } elseif ($_menu['level'] == self::MENU_LEVEL_SECOND) {
                $menu_second[] = $_menu;
            }
        }

        $menu_first = quickSortToArray($menu_first, 'weight');

        if (!empty($menu_second)) {
            $menu_second = quickSortToArray($menu_second, 'weight');
            foreach ($menu_first as $k => $v) {
                foreach ($menu_second as $_temp) {
                    if ($v['id'] == $_temp['parent_id']) {
                        $menu_first[$k]['child_menu'][] = $_temp;
                    }
                }
            }
        }

        return $menu_first;
    }
}