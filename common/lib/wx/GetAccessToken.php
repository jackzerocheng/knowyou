<?php
/**
 * Message: 获取微信access token
 * User: jzc
 * Date: 2018/12/21
 * Time: 3:57 PM
 * Return:
 */

namespace common\lib\wx;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Yii;
use yii\base\Exception;

class GetAccessToken
{
    const WX_ACCESS_TOKEN_KEY = 'WX_ACCESS_TOKEN';

    /**
     * 获取微信access_token
     * 正确返回 {"access_token":"ACCESS_TOKEN","expires_in":7200}
     * 错误返回 {"errcode":40013,"errmsg":"invalid appid"}
     * @param $appID
     * @param $secret
     * @return mixed
     * @throws Exception
     */
    public function getAccessToken($appID, $secret)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appID}&secret={$secret}";

        Yii::warning("call wei_xin access_token", CATEGORIES_INFO);

        try {
            $response = (new Client())->get($url);
        } catch (RequestException $e) {
            Yii::error("cannot request to api.weixin.qq.com!", CATEGORIES_ERROR);
            return false;
        }

        $content = $response->getBody()->getContents();
        Yii::warning('request content:'.$content, CATEGORIES_WARN);
        $jsonContent = \GuzzleHttp\json_decode($content, true);
        if (isset($jsonContent['errcode'])) {
            Yii::error("get access token error;msg:".$content, CATEGORIES_ERROR);
            return false;
        }

        return $jsonContent;
    }
}