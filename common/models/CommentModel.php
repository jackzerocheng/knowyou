<?php
/**
 * Message: 评论表
 * User: jzc
 * Date: 2018/10/30
 * Time: 5:57 PM
 * Return:
 */

namespace common\models;

use common\cache\Comment\CommentCache;
use common\cache\Comment\CommentRedis;
use yii\base\Model;
use common\dao\Comment;
use Yii;

class CommentModel extends Model
{
    //评论状态
    const COMMENT_STATUS_NORMAL = 1;
    const COMMENT_STATUS_DELETED = 2;

    //Redis自增评论ID
    const BASE_COMMENT_ID = 'BASE_COMMENT_ID';//id = base_id * partition + uid % partition

    private $redis;
    private $cache;

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->redis = new CommentRedis();
        $this->cache = new CommentCache();
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
     * 获取某个文章下的评论列表
     * @param $id
     * @param $condition
     * @return array|mixed
     */
    public function getCommentList($id, $condition)
    {
        $commentList = $this->cache->getCommentList($id);

        if (empty($commentList)) {
            $data = $this->getAllList($id, $condition);

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

                $this->cache->setCommentList($id, json_encode($commentList));
            }
        }

        return $commentList;
    }

    /**
     * 回复评论
     * @param $data
     * @return bool|int
     */
    public function replyComment($data)
    {
        //优先提交到消息队列处理
        $rs = $this->redis->pushCommentReplyList(json_encode($data));

        if (!$rs) {//提交失败则直接插入
            $rs = $this->insert($data);
        }

        return $rs;
    }

    public function getMaxCommentId()
    {
        $rs = 0;
        $count = TABLE_PARTITION - 1;
        while ($count >= 0) {
            $tmp = (new Comment($count))->getMaxCommentId();
            $rs = $tmp > $rs ? $tmp : $rs;
            $count--;
        }

        return $rs;
    }

    /**
     * 发布评论，更新缓存
     * @param $info
     * @return bool|int
     */
    public function insert($info)
    {
        $commentId = $this->redis->getCommentId($info['uid']);
        if (!empty($this->getOneByCondition($commentId, []))) {//检测是否正确
            $maxId = $this->getMaxCommentId();

            $commentId = $maxId - $maxId % TABLE_PARTITION + TABLE_PARTITION + $info['uid'] % 4;
            $this->redis->setCommentId($commentId);
        }

        $info['id'] = $commentId;
        $rs = (new Comment($commentId))->insertData($info);
        if (!$rs) {
            Yii::error("insert data to comment failed;data:".json_encode($info), CATEGORIES_ERROR);
            return false;
        }

        return $rs;
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

    public function getAllList($id, $condition)
    {
        return (new Comment($id))->getAllList($condition);
    }

    public function getOneByCondition($id, $condition)
    {
        return (new Comment($id))->getOneByCondition($condition);
    }
}