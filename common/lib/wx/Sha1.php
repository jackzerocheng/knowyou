<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/12/21
 * Time: 10:33 AM
 * Return:
 */

namespace common\lib\wx;
use yii\base\Exception;

/**
 * SHA1 class
 *
 * 计算公众平台的消息签名接口.
 */
class Sha1
{
    /**
     * 用SHA1算法生成安全签名
     * @param string $token 票据
     * @param string $timestamp 时间戳
     * @param string $nonce 随机字符串
     * @param string $encrypt 密文消息
     * @return mixed
     */
    public function getSHA1($token, $timestamp, $nonce, $encrypt_msg)
    {
        //排序
        try {
            $array = array($encrypt_msg, $token, $timestamp, $nonce);
            sort($array, SORT_STRING);
            $str = implode($array);
            return array(ErrorCode::$OK, sha1($str));
        } catch (Exception $e) {
            //print $e . "\n";
            return array(ErrorCode::$ComputeSignatureError, null);
        }
    }
}