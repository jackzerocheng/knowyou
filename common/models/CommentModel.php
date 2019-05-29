<?php
/**
 * Message: 评论表
 * User: jzc
 * Date: 2018/10/30
 * Time: 5:57 PM
 * Return:
 */

namespace common\models;

use common\cache\Comment\CommentRedis;
use yii\base\Model;
use common\dao\Comment;
use Yii;

class CommentModel extends Model
{
    //评论状态
    const COMMENT_STATUS_NORMAL = 1;
    const COMMENT_STATUS_FORBIDDEN = 2;
    const COMMENT_STATUS_DELETED = 3;

    //Redis自增评论ID
    const BASE_COMMENT_ID = 'BASE_COMMENT_ID';//id = base_id * partition + uid % partition
    //评论缓存key
    const CACHE_COMMENT_LIST = 'WEB_COMMENT_LIST_';
    const CACHE_COMMENT_NUMBER = 'WEB_COMMENT_NUMBER_';
    const CACHE_DURATION = 60*60*24;//一天

    //redis消息队列
    const LIST_COMMENT_REPLY = 'WEB_COMMENT_REPLY';

    private $redis;

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->redis = new CommentRedis();
    }

    /**
     * 获取评论数
     * @param $id
     * @param $condition
     * @return int
     */
    public function getCountByCondition($id, $condition)
    {
        return (new Comment($id))->getCountByCondition($condition);
    }

    /**
     * 获取文章正常评论数
     * @param $id
     * @return int
     */
    public function getCommentNumber($id)
    {
        $commentNumber = $this->redis->getCommentNumber($id);

        //无缓存
        if (empty($commentNumber)) {
            $commentNumber = $this->getCountByCondition($id, ['article_id' => $id, 'status' => self::COMMENT_STATUS_NORMAL]);

            if (!empty($commentNumber)) {
                $this->redis->setCommentNumber($id, $commentNumber);
            }
        }

        return $commentNumber;
    }

    /**
     * 优先读取缓存数据
     * 如果不存在则读取DB
     * @param $id
     * @param $condition
     * @return array
     */
    public function getListByCache($id, $condition)
    {
        $cache = Yii::$app->cache;
        $commentNumber = $cache->get(self::CACHE_COMMENT_NUMBER.$id) ? : 0;
        $commentList = array();
        if ($commentNumber) { //走缓存
            $commentList = $cache->get(self::CACHE_COMMENT_LIST.$id);
            if (!empty($commentList)) {
                $commentList = json_decode($commentList, true);
            }
        }

        if (empty($commentNumber || empty($commentList))) {
            list($commentList, $commentNumber) = $this->getListByDb($id, $condition);
        }

        return array($commentList, $commentNumber);
    }

    /**
     * 主动读取DB数据并添加到缓存
     * @param $id
     * @param $condition
     * @return array
     */
    public function getListByDb($id, $condition)
    {
        $cache = Yii::$app->cache;
        $commentList = array();
        $commentNumber = $this->getCountByCondition($id, $condition);
        if ($commentNumber > 0) {
            $cache->set(self::CACHE_COMMENT_NUMBER.$id, $commentNumber, self::CACHE_DURATION);
            $data = (new Comment($id))->getAllList($condition);

            $tmp = array();
            if (!empty($data)) {
                //区分一级评论和二级评论
                foreach ($data as $k => $v) {
                    if (intval($v['parent_id']) == 0) {
                        $commentList[$v['id']] = $v;
                    } else {
                        $tmp[$v['parent_id']] = $v;
                    }
                }

                //插入二级评论  => 二级评论是个数组，可能有多个回复
                if (!empty($tmp)) {
                    foreach ($tmp as $k => $v) {
                        $commentList[$k]['child_comment'][] = $v;
                    }
                }

                $cache->set(self::CACHE_COMMENT_LIST.$id, json_encode($commentList), self::CACHE_DURATION);
            }
        }

        return array($commentList, $commentNumber);
    }

    /**
     * 发布评论，更新缓存
     * @param $info
     * @return bool|int
     */
    public function insert($info)
    {
        $baseCommentId = Yii::$app->redis->incr(self::BASE_COMMENT_ID);

        $commentId = $baseCommentId * Comment::TABLE_PARTITION + intval($info['uid']) % Comment::TABLE_PARTITION;

        $rs = (new Comment($commentId))->insertData($info);
        if (!$rs) {
            Yii::error("insert data to comment failed;data:".json_encode($info), CATEGORIES_ERROR);
            return false;
        }

        $this->getListByDb($info['article_id'], ['article_id' => $info['article_id']]);

        return $rs;
    }
}