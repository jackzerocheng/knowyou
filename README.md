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
