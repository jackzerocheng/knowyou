<?php
/**
 * Message: 文章model
 * User: jzc
 * Date: 2018/10/22
 * Time: 3:31 PM
 * Return:
 */

namespace common\models;

use common\cache\Article\ArticleCache;
use common\cache\Article\ArticleRedis;
use yii\base\Model;
use common\dao\Article;
use Yii;

class ArticleModel extends Model
{
    //文章状态
    const ARTICLE_STATUS_UNVERIFIED = 1;//待审核
    const ARTICLE_STATUS_NORMAL = 2;//正常
    const ARTICLE_STATUS_PRIVATE = 3;//隐私
    const ARTICLE_STATUS_UNCOMMENT = 4;//无法评论
    const ARTICLE_STATUS_DELETED = 5;//删除
    const ARTICLE_STATUS_NOT_PASS = 6;//审核未通过
    public $articleStatusMap = [
        self::ARTICLE_STATUS_UNVERIFIED => '待审核',
        self::ARTICLE_STATUS_NORMAL => '正常',
        self::ARTICLE_STATUS_PRIVATE => '隐私',
        self::ARTICLE_STATUS_UNCOMMENT => '无法评论',
        self::ARTICLE_STATUS_DELETED => '删除',
        self::ARTICLE_STATUS_NOT_PASS => '审核未通过'
    ];

    const REDIS_EXPIRE_TIME = 259200;//三天
    const BASE_ARTICLE_ID_KEY = 'BASE_ARTICLE_ID';//id = base_id * partition + uid % partition
    const ARTICLE_COVER_DEFAULT = 'http://data.jianmo.top/img/default/default_cover.png';//文章默认封面
    const TABLE_PARTITION = 4;

    private $redis;//redis缓存
    private $cache;//mem缓存

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->redis = new ArticleRedis();
        $this->cache = new ArticleCache();
    }

    /**
     * ID批量查询
     * @param array $ids
     * @return array
     */
    public function getListByIds(array $ids)
    {
        if (empty($ids)) {
            return [];
        }

        $rs = [];
        foreach ($ids as $_id) {
            if (empty($_id)) {
                continue;
            }

            $info = $this->getArticleInfo($_id);
            if (!empty($info)) {
                $rs[] = $info;
            }
        }

        return $rs;
    }

    /**
     * 获取最新活跃文章
     * 默认20条
     * @return array
     */
    public function getActiveArticle()
    {
        $articleList = [];
        //获取缓存中的ID列表
        $ids = $this->redis->getActiveArticleID();
        if (!empty($ids)) {
            $articleList = $this->getListByIds($ids);
        }

        //没缓存情况下
        if (empty($ids)) {
            $articleList = (new ArticleIndexModel())->getListByCondition(['status' => self::ARTICLE_STATUS_NORMAL], 20);

            //设置缓存
            if (!empty($articleList)) {
                foreach ($articleList as $_article) {
                    $this->redis->setActiveArticleID($_article['id'], time());
                }
            }
        }



        return $articleList;
    }

    /**
     * 获取文章阅读数
     * @param $id
     * @return int
     */
    public function getArticleReadNumber($id)
    {
        $readNumber = $this->redis->getArticleReadNumber($id);

        //无缓存
        if (!$readNumber) {
            $articleInfo = $this->getOneByCondition($id, ['id' => $id]);

            if (!empty($articleInfo)) {
                $readNumber = intval($articleInfo['read_number']);
                $this->redis->setArticleReadNumber($id, $readNumber);
            }
        }

        return $readNumber;
    }

    /**
     * 自增阅读数
     * @param $id
     * @return mixed
     */
    public function incrArticleReadNumber($id)
    {
        return $this->redis->incrArticleReadNumber($id);
    }

    /**
     * 返回文章总数 - 缓存 or DB
     * @return int
     */
    public function getArticleTotal()
    {
        $number = $this->redis->getArticleTotal();

        if (empty($number)) {
            $number = $this->getCountByCondition([]);

            if (!empty($number)) {
                $this->redis->setArticleTotal($number);
            }
        }

        return intval($number);
    }

    /**
     * 获取单个文章信息
     * @param $id
     * @return array|mixed
     */
    public function getArticleInfo($id)
    {
        $articleInfo = $this->cache->getArticleInfo($id);

        //无缓存
        if (empty($articleInfo)) {
            $articleInfo = $this->getOneByCondition(['id' => $id], []);

            if (!empty($articleInfo)) {
                $this->cache->setArticleInfo($id, json_encode($articleInfo));
            }
        }

        return $articleInfo;
    }

    /**
     * 从DB中获取总表记录数
     * @param null $condition
     * @return int
     */
    public function getCountByCondition($condition)
    {
        $count = Article::TABLE_PARTITION;
        $result = 0;

        while ($count - Article::TABLE_PARTITION < Article::TABLE_PARTITION) {
            $article  = new Article($count);

            $result = $result + $article->getCountByCondition($condition);
            $count++;
        }

        return $result;
    }

    /**
     * 从所有表中获取文章记录
     * 需要当无指定条件时，每次返回数据不同
     * @param null $condition
     * @param int $limit //每个分表里取的数量
     * @param $offset
     * @return array
     */
    public function getListByCondition($condition = null, $limit = 10, $offset = 0)
    {
        $count = Article::TABLE_PARTITION;
        $result = array();

        while ($count - Article::TABLE_PARTITION < Article::TABLE_PARTITION) {
            $article = new Article($count);

            $result = array_merge($result, $article->getListByCondition($condition, $limit, $offset));
            $count++;
        }

        return $result;
    }

    /**
     * 获取符合条件的所有数据，受limit限制
     * @param $key
     * @param array $condition
     * @param int $limit
     * @return mixed
     */
    public function getAllList($key, $condition = array(), $limit = 1000)
    {
        $rs = (new Article($key))->getAllList($condition, $limit);
        return $rs;
    }

    /**
     * 查询单条文章记录，注意ID可传入UID或者article_id
     * @param $id
     * @param null $condition
     * @return mixed
     */
    public function getOneByCondition($id, $condition)
    {
        $index = intval($id) % Article::TABLE_PARTITION;
        $article = new Article($index);
        $data = $article->getOneByCondition($condition);
        if (!empty($data)) {
            $data['tag_msg'] = (new TagModel())->tagMap[$data['tag']];
        }

        return $data;
    }

    /**
     * 插入文章并返回文章ID
     * @param array $data
     * @return int
     */
    public function insert(array $data)
    {
        if (empty($data) || empty($data['uid'])) {
            return false;
        }

        $redisClient = Yii::$app->redis;
        $baseArticleId = $redisClient->incr(self::BASE_ARTICLE_ID_KEY);

        $articleID = $baseArticleId * Article::TABLE_PARTITION + $data['uid'] % Article::TABLE_PARTITION;
        $data['id'] = $articleID;

        $transaction = Yii::$app->db->beginTransaction();

        //插入文章数据
        if (!(new Article($data['uid']))->insertData($data)) {
            Yii::warning("insert data into article failed;uid:{$data['uid']};article_id:{$articleID}", CATEGORIES_WARN);
            $transaction->rollBack();
            return 0;
        }

        //插入索引数据
        if (!$articleIndexID = (new ArticleIndexModel())->insert($articleID)) {
            $transaction->rollBack();
            return 0;
        }

        $transaction->commit();
        Yii::info("new article data;article_id:{$articleID};article_index_id:{$articleIndexID}", CATEGORIES_INFO);
        return $articleID;
    }

    /**
     * 批量更新
     * index只能指定一个条件！
     * @param $key
     * @param $data
     * @param $index
     * @return int
     */
    public function updateBatch($key, $data, $index)
    {
        return (new Article($key))->updateBatch($data, $index);
    }
}