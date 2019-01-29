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
    public $requireAccessToken = false;

    public function actionIndex()
    {
        $params = (new Request())->get();
        Yii::warning('wei_xin get_params:'.json_encode($params), CATEGORIES_WARN);
        if (isset($params['echostr'])) {//公众号接入时的验证
            echo $this->valid($params);
            exit();
        }

        /*
         * 接收消息并处理
         * 处理失败后直接回复空字符串或者content为success
         */
        $data = file_get_contents("php://input");
        Yii::warning('wei_xin post_data:'.$data, CATEGORIES_WARN);
        if (empty($data)) {
            echo '';
            exit();
        }

        //处理xml结构
        //libxml_disable_entity_loader(true);
        //$content = json_decode(json_encode(simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

        //消息解密 - 采用明文模式则不需要解密
        $msg = '';
        $pc = new WxBizMsgCrypt(WX_TOKEN, WX_AES_KEY, WX_APP_ID);
        $rs = $pc->decryptMsg($params['msg_signature'], $params['timestamp'], $params['nonce'], $data, $msg);
        Yii::warning('接收消息解密内容：'.$msg, CATEGORIES_WARN);
        if ($rs != 0) {
            echo '';
            exit();
        } else {
            $replyMsg = $this->dealMsg($msg);
        }

        $resMsg = $this->transferMsg($msg, $replyMsg);//组合xml消息体
        Yii::warning('回复消息xml:'.$resMsg, CATEGORIES_WARN);

        //消息加密
        $time = time();
        $nonce = '123456';
        $pc->encryptMsg($replyMsg, $time, $nonce, $resMsg);
        $encryptResMsg = "<xml><Encrypt><![CDATA[{$resMsg}]></Encrypt><TimeStamp>{$time}</TimeStamp><Nonce>{$nonce}</Nonce></xml>";
        Yii::warning('加密后的回复消息xml:'.$encryptResMsg, CATEGORIES_WARN);

        echo $encryptResMsg;
    }

    /**
     * 接入验证
     * signature 微信加密签名
     * timestamp 时间戳
     * nonce 随机数
     * echostr 随机字符串
     * @param array $params
     * @return string
     */
    public function valid(array $params)
    {
        if (
            empty($params)
            || empty($params['timestamp'])
            || empty($params['nonce'])
            || empty($params['signature'])
            || empty(['echostr'])
        ) {
           return '';
        }

        $tmpArray = array(WX_TOKEN, $params['timestamp'], $params['nonce']);
        sort($tmpArray, SORT_STRING);
        $tmpStr = implode($tmpArray);
        $tmpStr = sha1($tmpStr);
        if ($params['signature'] == $tmpStr) {
            return $params['echostr'];//输出随机字符串
        }

        return '';
    }

    /**
     * 生成回复消息的xml格式
     * @param array $data
     * @param string $msg
     * @return bool
     */
    public function transferMsg($data = array(), $msg = '')
    {
        $format = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";

        $result = sprintf($format, $data['ToUserName'], $data['FromUserName'], time(), $msg);
        return $result;
    }

    /**
     * 价值一个亿的AI核心代码
     * @param string $msg
     * @return mixed|string
     */
    public function dealMsg($msg = '')
    {
        $key = [',','.','?','，','。','？', '吗','嘛','吧','的'];

        if (!empty($msg)) {
            if (in_array(mb_substr($msg, -1),$key)) {
                $msg = mb_substr($msg, 0, -1);
            }

            if (strpos($msg, '我') !== false && strpos($msg, '你') !== false) {
                $content = '';
                $len = mb_strlen($msg);
                for ($i = 0; $i < $len; $i++) {
                    $tmp = mb_substr($msg, $i, 1);
                    if ($tmp == '我') {
                        $tmp = '你';
                    } elseif ($tmp == '你') {
                        $tmp = '我';
                    }

                    $content = $content . $tmp;
                }

                return $content;
            } elseif (strpos($msg, '我') !== false) {
                $msg = str_replace('我', '你', $msg);
            } elseif (strpos($msg, '你') !== false) {
                $msg = str_replace('你', '我', $msg);
            }
        }

        return $msg;
    }
}