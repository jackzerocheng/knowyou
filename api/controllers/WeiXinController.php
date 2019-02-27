<?php
/**
 * Message: 微信公众号开发者接入
 * User: jzc
 * Date: 2018/12/20
 * Time: 5:51 PM
 * Return:
 */

namespace api\controllers;

use common\lib\StringHelper;
use common\models\WX\WxRulesModel;
use common\models\WX\WxUserModel;
use yii\web\Request;
use Yii;
use common\lib\wx\WxBizMsgCrypt;
use common\models\WX\WxRecordModel;

class WeiXinController extends CommonController
{
    public $requireAccessToken = false;
    public $helpStr = "感谢关注本公众号！留言请发送#我要留言#留言内容，例如#我要留言#需要一份Java资料;\n关键字回复请发送$关键字$;\n需要帮助请发送@帮助@；\n其他留言则由智能客服处理。感谢支持~~\n";

    public function actionIndex()
    {
        $params = (new Request())->get();
        Yii::warning('wei_xin get_params:'.json_encode($params), CATEGORIES_WARN);
        if (isset($params['echostr'])) {//公众号接入时的验证
            Yii::warning('update config', CATEGORIES_WARN);
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
        libxml_disable_entity_loader(true);
        $content = json_decode(json_encode(simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

        /*
         * 订阅消息/取消订阅
         */
        if (isset($content['Event'])) {
            Yii::warning('New Subscribe', CATEGORIES_WARN);
            echo $this->transferMsg($content, $this->welcomeBySub($content));
            exit();
        }

        //样本记录数据库
        $recordModel = new WxRecordModel();
        $keys = getArrayKey($recordModel->typeMap, $this->getRealValue($content['MsgType']));//查找类型对应键值
        $data = [
            'msg_id' => $this->getRealValue($content['MsgId']),
            'msg_type' => $keys[0],
            'to_user_name' => $this->getRealValue($content['ToUserName']),
            'from_user_name' => $this->getRealValue($content['FromUserName']),
            'content' => $this->getRealValue($content['Content']),
        ];

        if (!$recordModel->insert($data)) {
            Yii::error('wx insert record failed;data:'.json_encode($data),CATEGORIES_ERROR);
        }

        //消息解密 - 采用明文模式则不需要解密
        /*
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
        */

        //消息类型处理
        switch ($keys[0]) {
            case $recordModel::MSG_TYPE_TEXT :
                $content['Content'] = $this->dealTextMsg($content['Content']);
                break;
            case $recordModel::MSG_TYPE_IMAGE :
                $content['Content'] = '图片很美丽，但你更美丽哦~';
                break;
            default :
                $content['Content'] = '小主对不起，暂时无法支持该类消息哦';
                break;
        }

        $resMsg = $this->transferMsg($content, $content['Content']);//组合xml消息体
        Yii::warning('回复消息xml:'.$resMsg, CATEGORIES_WARN);

        //消息加密
        /*
        $time = time();
        $nonce = '123456';
        $pc->encryptMsg($replyMsg, $time, $nonce, $resMsg);
        $encryptResMsg = "<xml><Encrypt><![CDATA[{$resMsg}]></Encrypt><TimeStamp>{$time}</TimeStamp><Nonce>{$nonce}</Nonce></xml>";
        Yii::warning('加密后的回复消息xml:'.$encryptResMsg, CATEGORIES_WARN);
        */

        echo $resMsg;
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
            || empty($params['echostr'])
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

        $result = sprintf($format, $data['FromUserName'], $data['ToUserName'], time(), $msg);
        return $result;
    }

    /**
     * 去除微信的外包层
     * @param $str
     * @return mixed
     */
    public function getRealValue($str)
    {
        if (strpos($str, '<![CDATA[') !== false) {
            $str = substr($str, 9);
        }

        if (strpos($str, ']]>') !== false) {
            $str = substr($str, 0, -3);
        }

        return $str;
    }

    /**
     * 价值一个亿的AI核心代码
     * @param string $msg
     * @return mixed|string
     */
    public function dealTextMsg($msg = '')
    {
        $msg = $this->getRealValue($msg);

         if (mb_substr($msg, 0, 6) == '#我要留言#') {//留言处理
             return '暂未开发该模块。。。Sorry，有问题QQ1304713342联系';
         } elseif (mb_substr($msg, 0, 1) == '$' && mb_substr($msg, -1, 1) == '$' && mb_strlen($msg) > 2) {//关键字
             $keyWords = (new WxRulesModel())->getRuleKeys(['status' => WxRulesModel::STATUS_OPEN,
                 'type' => WxRulesModel::TYPE_KEY_WORD]);
             $input = mb_substr($msg, 1);
             $input = mb_substr($input, 0, -1);
             if (isset($keyWords[$input])) {
                 return $keyWords[$input];
             }

             return '';
         } elseif ($msg == '@帮助@') {
             return $this->helpStr;
         } else {
             $keyWords = (new WxRulesModel())->getRuleKeys(['status' => WxRulesModel::STATUS_OPEN,
                 'type' => WxRulesModel::TYPE_KEY_WORD]);
             if (isset($keyWords[$msg])) {
                 return $keyWords[$msg];
             }

             $illegalWord = (new WxRulesModel())->getRuleKeys(['status' => WxRulesModel::STATUS_OPEN,
                 'type' => WxRulesModel::TYPE_ILLEGAL_WORD]);
             //长字符串下大量敏感词会消耗大量计算时间
             if (!empty($illegalWord)) {//敏感词替换
                 foreach ($illegalWord as $_key => $value) {
                     if (mb_strpos($msg, $_key) !== false) {
                         $msg = str_replace($_key, $value, $msg);
                     }
                 }
             }

             /*
             * 简单逻辑替换
             */
             $key = [',','.','?','，','。','？', '吗','嘛','吧','的','呀','啊'];
             if (!empty($msg) && mb_strlen($msg) > 1) {
                 if (in_array(mb_substr($msg, -1),$key)) {
                     $msg = mb_substr($msg, 0, -1);
                 }

                 if (mb_strpos($msg, '我') !== false && mb_strpos($msg, '你') !== false) {
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
                 } elseif (mb_strpos($msg, '我') !== false) {
                     $msg = str_replace('我', '你', $msg);
                 } elseif (mb_strpos($msg, '你') !== false) {
                     $msg = str_replace('你', '我', $msg);
                 }
             }

             return $msg;
         }
    }

    public function welcomeBySub(array $userInfo)
    {
        $wxUserModel = new WxUserModel();
        $data = [
            'to_user_name' => $this->getRealValue($userInfo['ToUserName']),
            'from_user_name' => $this->getRealValue($userInfo['FromUserName']),
            'create_time' => $this->getRealValue($userInfo['CreateTime']),
            'msg_type' => $this->getRealValue($userInfo['MsgType']),
            'event' => $this->getRealValue($userInfo['Event'])
        ];
        if (!$wxUserModel->insert($data)) {
            Yii::error('insert wx user failed!data:'.json_encode($data), CATEGORIES_ERROR);
        }
        Yii::warning('new user;name:'.$userInfo['FromUserName'], CATEGORIES_WARN);

        return $this->helpStr;
    }
}