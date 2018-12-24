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
        $data = (new Request())->post();

        $pc = new WxBizMsgCrypt(WX_TOKEN, WX_AES_KEY, WX_APP_ID);
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




        /* 接入
        $params = (new Request())->get();

        Yii::warning('wei_xin request:'.json_encode($params), CATEGORIES_WARN);
        $tmpArray = array(WX_TOKEN, $params['timestamp'], $params['nonce']);
        sort($tmpArray, SORT_STRING);
        $tmpStr = implode($tmpArray);
        $tmpStr = sha1($tmpStr);

        if ($params['signature'] == $tmpStr) {
            echo $params['echostr'];
            exit();
        }

        $this->outputJson('failed');
        */
    }

    public function getSignature($token, $timestamp, $nonce)
    {
        $tmpArray = array(WX_TOKEN, $timestamp, $nonce);
        sort($tmpArray, SORT_STRING);
        $tmpStr = implode($tmpArray);
        $tmpStr = sha1($tmpStr);

        return$tmpStr;
    }
}