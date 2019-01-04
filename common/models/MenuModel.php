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
use Yii;

class MenuModel extends Model
{
    //菜单等级
    const MENU_LEVEL_FIRST = 1;//一级菜单
    const MENU_LEVEL_SECOND = 2;//二级子菜单
    public $menuLevelMap = [
        self::MENU_LEVEL_FIRST => '一级菜单',
        self::MENU_LEVEL_SECOND => '二级菜单'
    ];

    //菜单状态
    const MENU_STATUS_USING = 1;
    const MENU_STATUS_STOP = 2;
    const MENU_STATUS_DELETED = 3;//删除
    public $menuStatusMap = [
        self::MENU_STATUS_USING => '展示中',
        self::MENU_STATUS_STOP => '下架中'
    ];

    const MENU_TYPE_FRONTEND = 1;//前台
    const MENU_TYPE_BACKEND = 2;//后台

    /**
     * 获取完整菜单
     * 权重越小越靠前
     * @param $type integer
     * @param $all
     * @return array
     */
    public function getMenuList($type = 1, $all = false)
    {
        $params = ['type' => $type];
        if (!$all) {//只获取展示中数据
            $params['status'] = self::MENU_STATUS_USING;
        } else {//获取除删除外的数据
            $params['except_status'] = self::MENU_STATUS_DELETED;
        }
        $menuList = $this->getListByCondition($params);

        if (empty($menuList)) {
            return array();
        }

        /**
         * 拆分一级菜单和二级菜单
         */
        $menu_first = array();
        foreach ($menuList as $_menu) {
            if ($_menu['level'] == self::MENU_LEVEL_FIRST) {
                $menu_first[] = $_menu;
            } elseif ($_menu['level'] == self::MENU_LEVEL_SECOND) {
                $menu_second[] = $_menu;
            }
        }

        $menu_first = quickSortToArray($menu_first, 'weight', true);

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

    /**
     * @param $condition
     * @return mixed
     */
    public function getListByCondition($condition)
    {
        return (new Menu())->getListByCondition($condition);
    }

    /**
     * @param $condition
     * @return array
     */
    public function getOneByCondition($condition)
    {
        return (new Menu())->getOneByCondition($condition);
    }

    /**
     * 添加菜单
     * @param array $data
     * @return int
     */
    public function insert(array $data)
    {
        return (new Menu())->insertInfo($data);
    }

    /**
     * 更新
     * @param array $data
     * @param $condition
     * @return int
     */
    public function update(array $data, $condition)
    {
        return (new Menu())->updateInfo($data, $condition);
    }

    /**
     * 删除
     * @param $condition
     * @return bool|int
     */
    public function delete($condition)
    {
        if (empty($condition)) {//禁止无条件删除
            return false;
        }

        return (new Menu())->deleteInfo($condition);
    }

    /**
     * 检查插入/更新菜单时的数据正确性
     * @param array $data
     * @return bool
     */
    public function checkData(array $data)
    {
        if (empty($data)) {
            Yii::$app->session->setFlash('edit_message', '提交数据为空');
            return false;
        } elseif (($data['level'] == self::MENU_LEVEL_FIRST && $data['parent_id'] != 0)
            || ($data['level'] == self::MENU_LEVEL_SECOND && $data['parent_id'] == 0)) {//菜单级别和父级菜单关系判断
            Yii::$app->session->setFlash('edit_message', '一级菜单不能有父级菜单，二级菜单必须有父级菜单');
            return false;
        } elseif (intval($data['weight']) < 0) {
            Yii::$app->session->setFlash('edit_message', '权重不能为负值');
            return false;
        }

        return true;
    }
}