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
    const MENU_LEVEL_FIRST = 1;
    const MENU_LEVEL_SECOND = 2;

    const MENU_STATUS_USING = 1;
    const MENU_STATUS_STOP = 2;

    /**
     * 获取完整菜单
     * @return array
     */
    public function getMenuList()
    {
        $menuList = (new Menu())->getListByCondition();

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

        quickSortToArray($menu_first, 'weight');

        if (!empty($menu_second)) {
            quickSortToArray($menu_second, 'weight');
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