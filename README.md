# knowyou
# 简 · 默
-----

>  **分布式后端项目**

> **类微博社区**

> 框架：yii2

> 语言：PHP7+

> 数据库：MySQL5.6.40

> 分库分表：分表不分库

> 操作系统：centos7.5

> 缓存：Redis

> 开发周期：每周更新

----
* backend   后台管理
* frontend  前台展示
* api       请求接口
----
* Ueditor：引用富文本编辑器
* 文档地址：http://fex.baidu.com/ueditor/#server-php

---

* **Lib所用工具**
* AES加密算法
* RSA加密算法

---
* 手动执行脚本方式：/项目根目录/yii /console下控制器名/方法名
* 如 php /www/yii2/yii /test/index
* 多个单词的controller用-划分
* 如post-comment 对应 app\controllers\PostCommentController
---
* 定时任务配置：crontab

----
> 文章索引表，用于按时间顺序存储文章
> 水平分表

----
**关于环境配置**
* 参数YII_ENV决定了当前项目环境
框架中写法
> defined('YII_ENV') or define('YII_ENV', 'dev');

> 于入口文件index.php定义

----
* 后台采用layui
* 链接：https://www.layui.com/doc/

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