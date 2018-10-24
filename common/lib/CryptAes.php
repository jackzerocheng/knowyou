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

    public function encrypt($data)
    {
        return openssl_encrypt($data, $this->method, $this->key, $this->options, $this->iv);
    }

    public function decrypt($data)
    {
        return openssl_decrypt($data, $this->method, $this->key, $this->options, $this->iv);
    }
}