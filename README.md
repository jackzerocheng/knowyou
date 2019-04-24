# knowyou
# 简 · 默
`仅用于个人学习开源，禁止任何未经允许的商业用途`

## 项目参数

>  **分布式Web项目**（类微博社区）

> 基础框架：yii2

> 语言：PHP7.2(7.2以上才能支持MySQL8的用户密码，修改了加密方式)

> 数据库：MySQL8

> 分库分表：传统Hash分表

> 操作系统：entos7.5

> 缓存组件：Redis，Memcached

> 日志系统：yii2自带文件日志

> 监控系统：

> 开发周期：每周更新

---
##   依赖扩展
* openssl   用于AES和RSA加密
* Redis     用于生成自增ID与计数变量，实现消息队列（考虑到实际场景和成本，就不上kafka了，，）
* Memcached 用于缓存文章及评论内容
* kafka(暂不需要)     消息队列，用于写入评论或其他频繁执行的操作
---
## 其他插件
* Ueditor：百度富文本编辑器(http://fex.baidu.com/ueditor/#server-php)
* layui:   前端开发框架


## 前言
```html
<div>部分文件涉及数据敏感性，需要手动添加</div>
<ul>
<li>knowoyu/common/const.php -- 包含系统基本常量参数,如密钥，时间戳等</li>
<li>DB、COOKIE等配置都写在了本地文件knowyou/common/config/main-local.php</li>
</ul>

```

## 系统截图

![首页](https://github.com/jackzerocheng/knowyou/blob/master/environments/doc/projectImage/%E9%A6%96%E9%A1%B5.png)
![后台列表页](https://github.com/jackzerocheng/knowyou/blob/master/environments/doc/projectImage/%E5%90%8E%E5%8F%B0%E5%88%97%E8%A1%A8%E9%A1%B5.png)
![登录页](https://github.com/jackzerocheng/knowyou/blob/master/environments/doc/projectImage/%E7%99%BB%E5%BD%95%E9%A1%B5.png)
![文章列表](https://github.com/jackzerocheng/knowyou/blob/master/environments/doc/projectImage/%E6%96%87%E7%AB%A0%E5%88%97%E8%A1%A8.png)
![添加菜单](https://github.com/jackzerocheng/knowyou/blob/master/environments/doc/projectImage/%E6%B7%BB%E5%8A%A0%E8%8F%9C%E5%8D%95.png)


## 公众号模块
![微信对话](https://github.com/jackzerocheng/knowyou/blob/master/environments/doc/projectImage/%E5%BE%AE%E4%BF%A1%E5%AF%B9%E8%AF%9D.png)
![公众号管理](https://github.com/jackzerocheng/knowyou/blob/master/environments/doc/projectImage/%E5%BE%AE%E4%BF%A1%E5%AF%B9%E8%AF%9D.png)
## 主要模块

- frontend
- 前台展示模块，主要包括网站首页展示，文章展示，论坛等等网站主体功能
- 类似微博社区

* backend 
* 后台管理，进行站点管理
* CMS
* 后台采用layui
* 链接：https://www.layui.com/doc/


- api
- 三方接口请求模块

---

* **Lib所用工具**
* AES加密算法
* RSA加密算法


## 基础知识
* 手动执行脚本方式：/项目根目录/yii /console下控制器名/方法名
* 如 php /www/yii2/yii /test/index
* 多个单词的controller用-划分
* 如post-comment 对应 app\controllers\PostCommentController
---
* 定时任务配置：crontab



----
**关于环境配置**
* 参数YII_ENV决定了当前项目环境
框架中写法
> defined('YII_ENV') or define('YII_ENV', 'dev');

> 于入口文件index.php定义

----


-----
* yii操作数据库
* 查询所有：$posts = Yii::$app->db->createCommand('SELECT * FROM post')->queryAll();
* 查询一条：$post = Yii::$app->db->createCommand('SELECT * FROM post WHERE id=1')->queryOne();
* 查询一列：$titles = Yii::$app->db->createCommand('SELECT title FROM post')->queryColumn();
* 查询标量值：$count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM post')->queryScalar();
* `绑定参数`：$post = Yii::$app->db->createCommand('SELECT * FROM post WHERE id=:id AND status=:status')
                    ->bindValue(':id', $_GET['id'])
                    ->bindValue(':status', 1)
                    ->queryOne();
* 插入：Yii::$app->db->createCommand()->insert('user', [
           'name' => 'Sam',
           'age' => 30,
       ])->execute();
* 更新：Yii::$app->db->createCommand()->update('user', ['status' => 1], 'age > 30')->execute();
* 删除：Yii::$app->db->createCommand()->delete('user', 'status = 0')->execute();
* 原子操作：Yii::$app->db->createCommand()->upsert('pages', [
           'name' => 'Front page',
           'url' => 'http://example.com/', // url is unique
           'visits' => 0,
       ], [
           'visits' => new \yii\db\Expression('visits + 1'),
       ], $params)->execute();