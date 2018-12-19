<?php
/**
 * Message: 对称加密
 * User: jzc
 * Date: 2018/10/24
 * Time: 11:23 AM
 * Return:
 */

namespace common\lib;


class CryptAes
{
    public $key;
    public $method;
    public $options;
    public $iv;

    /**
     * CryptAes constructor.
     * @param string $key     // 密钥一定要自己设置！且复杂度够高！
     * @param string $method  //加密方式openssl_get_cipher_methods获取可用加密
     * @param int $options    //true返货raw数据格式，否则返回base64编码
     * @param string $iv      //初始化向量
     */
    public function __construct($key = 'default_knowyou_key', $method = 'AES-128-ECB', $options = 0, $iv = '')
    {
        $this->key = $key;
        $this->method = $method;
        $this->options = $options;

        if (empty($iv)) {
            $iv_len = openssl_cipher_iv_length($method);
            $iv = openssl_random_pseudo_bytes($iv_len);
        }

        $this->iv = $iv;
    }

    /**
     * AES加密
     * @param $data  //待加密字符串
     * @return string
     */
    public function encrypt($data)
    {
        return openssl_encrypt($data, $this->method, $this->key, $this->options, $this->iv);
    }

    /**
     * AES解密，需保证密钥一致
     * @param $data  //待解密字符串
     * @return string
     */
    public function decrypt($data)
    {
        return openssl_decrypt($data, $this->method, $this->key, $this->options, $this->iv);
    }
}