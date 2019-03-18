<?php
/**
 * Message: KMP算法
 * PHP中strpos/mb_strpos函数实际上也提供了相同的功能
 * Java中indexOf
 * User: jzc
 * Date: 2019/1/30
 * Time: 4:33 PM
 * Return:
 */

namespace common\lib;


class Kmp
{
    /**
     * 计算next数组
     * 每个位置在不匹配情况下的回跳地址
     * @param $ps //匹配字符串
     * @return array
     */
    public static function getNext($ps)
    {
        if (empty($ps)) {
            return [];
        }

        $next = array();//next数组记录的是当前位置不匹配时，需要重新匹配的位置
        $next[0] = -1;//匹配串的第一位，不匹配时不再移动匹配串指针
        $j = 0;//前指针
        $k = -1;//后指针
        while ($j < mb_strlen($ps) - 1) {//这里到length-1，是因为while中找的是相同的两个位置，然后定位j+1回跳重匹配的位置
            if ($k == -1 || $ps[$j] == $ps[$k]) {//匹配串第一位，或者是匹配串中两位置相同，那j+1自然是跳到k+1位置
                if ($ps[++$j] == $ps[++$k]) {//如果前后都相同，那么跳过这个位置（回跳无意义）
                    $next[$j] = $next[$k];
                } else {
                    $next[$j] = $k;//匹配串的 第 j+1 位 需要跳转到 第 k+1 位
                }
            } else {
                $k = $next[$k];//不相等的情况下，后指针移到重匹配的位置
            }
        }

        return $next;
    }

    /**
     * 输入主串和匹配串，返回所匹配的第一个位置
     * 或者返回-1代表未找到
     * @param $ts //主串
     * @param $ps //待匹配串
     * @return int
     */
    public static function KMP($ts, $ps)
    {
        if (empty($ts) || empty($ps)) {
            return -1;
        }

        $i = 0;//目标串指针
        $j = 0;//匹配串指针
        $next = self::getNext($ps);//next数组
        while ($i < mb_strlen($ts) && $j < mb_strlen($ps)) {
            if ($j == -1 || $ts[$i] == $ps[$j]) {//按顺序比对，j=-1说明在匹配串头部，后移目标串指针
                $j++;
                $i++;
            } else {
                $j = $next[$j];//不匹配，那么就跳转重新匹配
            }
        }

        if ($j == mb_strlen($ps)) {//匹配到匹配串
            return $i - $j;
        } else {//未能匹配到
            return -1;
        }
    }
}