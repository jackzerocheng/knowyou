<?php
/**
 * Message: 微信公众号开发者接入
 * User: jzc
 * Date: 2018/12/20
 * Time: 5:51 PM
 * Return:
 */

namespace api\controllers;

use yii\web\Request;
use Yii;
use common\lib\wx\WxBizMsgCrypt;

class WeiXinController extends CommonController
{
    public $requireAccessToken = true;

    public function actionIndex()
    {
        //请求验证
        $params = (new Request())->get();

        Yii::warning('wei_xin request:'.json_encode($params), CATEGORIES_WARN);
        $tmpStr = $this->getSignature(WX_TOKEN, $params['timestamp'], $params['nonce']);
        if ($params['signature'] == $tmpStr) {
            echo $params['echostr'];
        } else {
            $this->outputJson('failed');
        }

        $this->outputJson('failed');

        $data = (new Request())->post();//获取加密消息
        Yii::warning('解密前'.$data, CATEGORIES_WARN);
        $pc = new WxBizMsgCrypt(WX_TOKEN, WX_AES_KEY, WX_APP_ID);
        $content = '';
        //消息解密
        $rs = $pc->decryptMsg($params['signature'], $params['timestamp'], $params['nonce'], $data, $content);
        if ($rs != 0) {
            $this->outputJson('failed');
        }
        Yii::warning('解密后:'.$content, CATEGORIES_WARN);
        exit();


        $xmlTree = new \DOMDocument();
        $xmlTree->load($data);

        $msgType = $xmlTree->getElementsByTagName('MsgType');
        if ($msgType == 'text') {
            $toUserName = $xmlTree->getElementsByTagName('ToUserName');
            $fromUserName = $xmlTree->getElementsByTagName('FromUserName');
            $createTime = $xmlTree->getElementsByTagName('CreateTime');
            $content = $xmlTree->getElementsByTagName('Content');
            $msgId = $xmlTree->getElementsByTagName('MsgId');

            $content = $pc->decryptMsg();
        } else {
            $this->outputJson('failed');
        }

    }

    public function getSignature($token, $timestamp, $nonce)
    {
        $tmpArray = array($token, $timestamp, $nonce);
        sort($tmpArray, SORT_STRING);
        $tmpStr = implode($tmpArray);
        $tmpStr = sha1($tmpStr);

        return $tmpStr;
    }
}