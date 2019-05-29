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
 * @param bool $toLong //输出整形
 * @param bool $userCdnSrcIp
 * @return int|null|string
 */
function getIP($toLong = false, $userCdnSrcIp = true)
{
    $onlineip = '';
    if ($userCdnSrcIp && $_SERVER['HTTP_CDN_SRC_IP'] && strcasecmp($_SERVER['HTTP_CDN_SRC_IP'], 'unknown')) {
        $onlineip = $_SERVER['HTTP_CDN_SRC_IP'];
    } elseif ($_SERVER['HTTP_X_FORWARDED_FOR'] && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], 'unknown')) {
        $onlineip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (!empty($_SERVER["HTTP_CLIENT_IP"])) {
        $onlineip = $_SERVER["HTTP_CLIENT_IP"];
    } elseif (!empty($_SERVER["REMOTE_ADDR"])) {
        $onlineip = $_SERVER["REMOTE_ADDR"];
    }

    preg_match("/[\d\.]{7,15}/", $onlineip, $onlineipmatches);
    $onlineip = $onlineipmatches [0] ? $onlineipmatches [0] : null;
    unset($onlineipmatches);
    if($toLong){
        $onlineip = ip2long($onlineip);
    }

    return $onlineip;
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
    if (count($arr) <= 1) {
        return $arr;
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

/**
 * 获取数组中对应值的键
 * 考虑可能存在重复值，返回数组，若是唯一值取array[0]
 * @param array $array
 * @param $value
 * @return array
 */
function getArrayKey(array $array, $value)
{
    $rs = array();
    if (!empty($array) && is_array($array)) {
        foreach ($array as $k => $v) {
            if ($v == $value) {
                $rs[] = $k;
            }
        }
    }

    return $rs;
}

function getEnvParam($key, $default = '')
{
    if (getenv($key)) {
        return getenv($key);
    } else {
        return $default;
    }
}

/**
 * 检索data中符合需求的值
 * @param array $data
 * @param array $needKeys
 * @return array
 */
function getNeedData(array $data, array $needKeys)
{
    if (!empty($data)) {
        foreach ($data as $k => $v) {
            if (!in_array($k, $needKeys)) {
                unset($data[$k]);
            }
        }
    }

    return $data;
}