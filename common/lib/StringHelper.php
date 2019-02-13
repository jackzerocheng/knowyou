<?php
/**
 * Message: 处理字符串相关算法函数
 * User: jzc
 * Date: 2019/2/13
 * Time: 10:56 AM
 * Return:
 */

namespace common\lib;


class StringHelper
{
    /**
     * 循环调用strpos，来查询出所有子串
     * 返回一个子串位置的数组
     * 使用mb_strpos来匹配中文字符
     * @param $haystack
     * @param $needle
     * @return array
     */
    public static function searchAllStr($haystack, $needle)
    {
        $rs = array();//用于保存所有的子串位置
        $start = 0;
        while (($start = mb_strpos($haystack, $needle, $start)) !== false) {
            $rs[] = $start;
            $start = $start + strlen($needle);//+len越过已匹配字符串
        }

        return $rs;
    }

    //public static function replaceAllStr($haystack,)
}