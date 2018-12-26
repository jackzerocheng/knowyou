<?php
/**
 * Message: 自动加载函数
 * User: jzc
 * Date: 2018/9/8
 * Time: 上午11:57
 * Return:
 */

/**
 * 密码加密算法  -- 加密扩充为64位
 * @param $basePassword
 * @return string
 */
function setPassword($basePassword)
{
    $md_passswd = md5($basePassword);
    $str_first = substr($md_passswd, 0, 16);
    $str_last = substr($md_passswd, -1, 16);
    return md5($str_first) . md5($str_last);
}


/**
 * 获取IP方法，获取不到则返回255.255.255.255
 * @return string
 */
function getIP()
{
    if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
        $cip = $_SERVER["HTTP_CLIENT_IP"];
    } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } elseif (!empty($_SERVER["REMOTE_ADDR"])) {
        $cip = $_SERVER["REMOTE_ADDR"];
    } else {
        $cip = "255.255.255.255";
    }

    return $cip;
}

/**
 * 返回毫秒时间戳
 * @return float
 */
function getMillisecond()
{
    list($t1, $t2) = explode(' ', microtime());
    return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
}

/**
 * 快排
 * 按照某一索引值对二维数组排序
 * @param $arr
 * @param $index
 * @param $asc   //默认升序
 * @return array
 */
function quickSortToArray($arr, $index, $asc = true)
{
    if (empty($arr)) {
        return array();
    }

    $key = $arr[0];
    unset($arr[0]);
    $arr_left = array();
    $arr_right = array();
    foreach ($arr as $k => $v) {
        if ($asc ? ($v[$index] <= $key[$index]) : ($v[$index] >= $key[$index])) {
            $arr_left[] = $v;
        } else {
            $arr_right[] = $v;
        }
    }

    if (!empty($arr_left)) {
        $arr_left = quickSortToArray($arr_left, $index);
    }

    if (!empty($arr_right)) {
        $arr_right = quickSortToArray($arr_right, $index);
    }

    return array_merge($arr_left, array($key), $arr_right);
}

function getEnvParam($key, $default = '')
{
    if (getenv($key)) {
        return getenv($key);
    } else {
        return $default;
    }
}