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
function getIP(){
    if(!empty($_SERVER["HTTP_CLIENT_IP"])){
        $cip = $_SERVER["HTTP_CLIENT_IP"];
    }
    elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
        $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    elseif(!empty($_SERVER["REMOTE_ADDR"])){
        $cip = $_SERVER["REMOTE_ADDR"];
    }
    else{
        $cip = "255.255.255.255";
    }
    return $cip;
}
