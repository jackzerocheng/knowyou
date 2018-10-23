<?php
/**
 * Message: Rsa加解密工具
 * User: jzc
 * Date: 2018/10/23
 * Time: 6:14 PM
 * Return:
 */

namespace common\lib;


class CryptRsa
{
    /**
     * 私钥加密
     * @param string $content
     * @param $privateKey
     * @return string
     */
    public function priEncrypt($content, $privateKey)
    {
        $privateId = openssl_pkey_get_private($privateKey);
        $encrypted = '';
        openssl_private_encrypt($content, $encrypted, $privateId);

        openssl_free_key($privateId);
        return base64_encode($encrypted);
    }

    /**
     * 公钥加密
     * @param $content
     * @param $publicKey
     * @return string
     */
    public function pubDecrypt($content, $publicKey)
    {
        $publicId = openssl_pkey_get_public($publicKey);
        $content = base64_decode($content);
        $decrypted = '';

        openssl_public_decrypt($content, $decrypted, $publicId);
        openssl_free_key($publicId);

        return $decrypted;
    }

    /**
     * 公钥加密
     * @param $content
     * @param $publicKey
     * @return string
     */
    public function pubEncrypt($content, $publicKey)
    {
        $publicId = openssl_pkey_get_public($publicKey);
        $encrypted = '';
        openssl_public_encrypt($content, $encrypted, $publicId);

        openssl_free_key($publicId);
        return base64_encode($encrypted);
    }

    /**
     * 私钥解密
     * @param $content
     * @param $privateKey
     * @return string
     */
    public function priDecrypt($content, $privateKey)
    {
        $privateId = openssl_pkey_get_private($privateKey);
        $content = base64_decode($content);
        $decrypted = '';

        openssl_private_decrypt($content, $decrypted, $privateId);
        openssl_free_key($privateId);

        return $decrypted;
    }
}