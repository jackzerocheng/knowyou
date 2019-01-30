<?php
/**
 * Message: 生成指定位数随机数
 * User: jzc
 * Date: 2018/12/19
 * Time: 5:53 PM
 * Return:
 */

namespace common\lib;


class RandomString
{
    private $baseNum = '0123456789';
    private $baseChar = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private $extendChar = '';

    /**
     * 默认没包含任何特殊字符，防止在不同编码下乱码
     * RandomString constructor.
     * @param string $extendChar //额外需要的字符
     */
    public function __construct($extendChar = '')
    {
        $this->extendChar = $extendChar;
    }

    /**
     * 输出指定长度下随机字符串
     * mt_rand在伪随机上已经足够优化！
     * @param $length
     * @param bool $includeChar
     * @param bool $includeNum
     * @return string
     */
    public function outputRandomString($length, $includeChar = true, $includeNum = true)
    {
        if ($length <= 0) {
            return '';
        }

        $finalString = $this->extendChar;
        if ($includeChar) {
            $finalString .= $this->baseChar;
        }

        if ($includeNum) {
            $finalString .= $this->baseNum;
        }

        $rs = '';
        $count = $length;
        $strLen = strlen($finalString);

        while ($count > 0) {
            $rs .= $finalString[mt_rand(0, $strLen - 1)];
            $count--;
        }

        return $rs;
    }
}