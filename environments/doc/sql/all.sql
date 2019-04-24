use knowyou;

/*
----------  账号相关
*/


create table knowyou_user00 (
uid int(11)  comment '依赖Redis生成',
username varchar(30)  not null default '',
password varchar(64)  not null DEFAULT '' comment 'ase加密',
head varchar(100) not null default '@web/img/default/default_head.jpg' comment '用户头像',
sex tinyint(4) default 0 comment '0保密1男2女',
signature varchar(50) DEFAULT '无个性，不签名' comment '个性签名',
phone varchar(20)  default '',
email varchar(30)  default '',
birthday date default '1996-10-01' comment '生日',
status tinyint(4) not null default 1 comment '1正常2封禁3删除',
updated_at timestamp not null DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
created_at timestamp not null DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
PRIMARY KEY (`uid`),
UNIQUE key un_un (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '用户表1';

create table knowyou_user01 (
uid int(11)  comment '依赖Redis生成',
username varchar(30)  not null default '',
password varchar(64)  not null DEFAULT '' comment 'ase加密',
head varchar(100) not null default '@web/img/default/default_head.jpg' comment '用户头像',
sex tinyint(4) default 0 comment '0保密1男2女',
signature varchar(50) DEFAULT '无个性，不签名' comment '个性签名',
phone varchar(20)  default '',
email varchar(30)  default '',
birthday date default '1996-10-01' comment '生日',
status tinyint(4) not null default 1 comment '1正常2封禁3删除',
updated_at timestamp not null DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
created_at timestamp not null DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
PRIMARY KEY (`uid`),
UNIQUE key un_un (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '用户表2';

create table knowyou_user02 (
uid int(11)  comment '依赖Redis生成',
username varchar(30)  not null default '',
password varchar(64)  not null DEFAULT '' comment 'ase加密',
head varchar(100) not null default '@web/img/default/default_head.jpg' comment '用户头像',
sex tinyint(4) default 0 comment '0保密1男2女',
signature varchar(50) DEFAULT '无个性，不签名' comment '个性签名',
phone varchar(20)  default '',
email varchar(30)  default '',
birthday date default '1996-10-01' comment '生日',
status tinyint(4) not null default 1 comment '1正常2封禁3删除',
updated_at timestamp not null DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
created_at timestamp not null DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
PRIMARY KEY (`uid`),
UNIQUE key un_un (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '用户表3';

create table knowyou_user03 (
uid int(11)  comment '依赖Redis生成',
username varchar(30)  not null default '',
password varchar(64)  not null DEFAULT '' comment 'ase加密',
head varchar(100) not null default '@web/img/default/default_head.jpg' comment '用户头像',
sex tinyint(4) default 0 comment '0保密1男2女',
signature varchar(50) DEFAULT '无个性，不签名' comment '个性签名',
phone varchar(20)  default '',
email varchar(30)  default '',
birthday date default '1996-10-01' comment '生日',
status tinyint(4) not null default 1 comment '1正常2封禁3删除',
updated_at timestamp not null DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
created_at timestamp not null DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
PRIMARY KEY (`uid`),
UNIQUE key un_un (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '用户表4';


create table knowyou_user_index00 (
id int(11) comment '索引ID，Redis递增',
uid int(11) not null default 0 comment '用户ID',
created_at timestamp not null default current_timestamp,
PRIMARY KEY (`id`),
UNIQUE KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '用户索引表';

create table knowyou_user_index01 (
id int(11) comment '索引ID，Redis递增',
uid int(11) not null default 0 comment '用户ID',
created_at timestamp not null default current_timestamp,
PRIMARY KEY (`id`),
UNIQUE KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '用户索引表';

create table knowyou_user_index02 (
id int(11) comment '索引ID，Redis递增',
uid int(11) not null default 0 comment '用户ID',
created_at timestamp not null default current_timestamp,
PRIMARY KEY (`id`),
UNIQUE KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '用户索引表';


create table knowyou_user_admin (
admin_id int(11)  comment '依赖Redis生成',
username varchar(30)  not null default '' comment '管理员昵称',
real_name varchar(30)  not null default '' comment '真实姓名',
password varchar(64)  not null DEFAULT '' comment '密码',
phone varchar(20)  default '',
email varchar(30)  default '',
head varchar(200) not null default '@web/img/default/default_head.png' comment '头像地址',
level tinyint(4) not null default 1 comment '管理员等级，1普通管理员2超级管理员',
status tinyint(4) not null default 1 comment '状态1正常，2删除',
last_login_time timestamp not null default '2018-10-01 00:00:00' comment '上次登录时间',
last_login_ip varchar(20) not null default '' comment '上次登录IP',
updated_at timestamp not null DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
created_at timestamp not null DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
PRIMARY KEY (`admin_id`),
UNIQUE key un_un (`username`) using BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '管理员表';

/*
 ------   系统相关
*/
create table knowyou_banner (
id int(11) AUTO_INCREMENT comment '运营位编号',
platform_id tinyint(4) not null default 1 comment '平台编号，1web，2安卓,3ios',
name varchar(50) not null default '' comment '运营位名称',
img varchar(200) default '' comment '图片链接',
link varchar(200) default '' comment '链接地址',
status tinyint(4) not null default 1 comment '状态，1正常2停用',
type tinyint(4) not null default 1 comment '类型，1普通运营位2广告位',
start_at date not null default '2018-10-01' comment '开始时间',
end_at date not null default '2018-10-01' comment '结束时间',
updated_at timestamp not null default '2018-10-01 00:00:00' comment '更新时间',
created_at timestamp not null default current_timestamp comment '创建时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '运营位';


create table knowyou_menu (
id int(11) AUTO_INCREMENT comment '菜单名称',
name varchar(20) not null default '' comment '菜单名称',
level tinyint(4) not null default 0 comment '菜单等级，1一级菜单',
parent_id int(11)  comment '父级菜单',
url varchar(200) not null default '' comment '菜单链接',
type tinyint(4) not null default 1 comment '菜单类型,1前台，2后台',
status tinyint(4) not null default 2 comment '状态，1正常2停用',
weight int(10) not null default 1 comment '菜单权重,越小排越前面',
updated_at timestamp not null default '2018-10-01 00:00:00' comment '更新时间',
created_at timestamp not null default current_timestamp comment '创建时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '菜单表';


create table knowyou_suggest (
id int(11) AUTO_INCREMENT comment '消息ID',
uid int(11) not null default 0 comment '留言用户ID',
content varchar(300) not null default '' comment '留言内容',
status tinyint(4) not null default 1 comment '1未回复，2已回复，3删除',
type tinyint(4) not null default 0 comment '留言类型，0未知',
created_at timestamp not null default current_timestamp comment '创建时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '留言表';

/*
-----------  文章相关
*/
create table knowyou_article00 (
id int(11) PRIMARY KEY comment 'baseID * partition + uid % partition',
uid int(11) not null default 0,
username varchar(30) not null default '',
head varchar(100) not null default '',
title varchar(50) not null default '' comment '标题',
cover varchar(100) not null default '' comment '封面图片',
content text  comment '文章内容',
forward_id int(11) default 0 comment '转发，原文章ID',
status tinyint(4) not null default 1 comment '文章状态，1正常2封禁（无法查看）3禁止评论4删除',
read_number int(11) not null default 0 comment '文章阅读数，定期更新DB',
praise_number int(11) not null default 0 comment '文章点赞数，定期更新DB',
dislike_number int(11) not null default 0 comment '文章不喜欢数',
tag tinyint(4) not null default 1 comment '文章标签，1未分类，后面大数据用',
updated_at timestamp not null default '2018-10-01 00:00:00',
created_at timestamp not null default current_timestamp,
index uid_article (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '文章表';

create table knowyou_article01 (
id int(11) PRIMARY KEY comment 'baseID * partition + uid % partition',
uid int(11) not null default 0,
username varchar(30) not null default '',
head varchar(100) not null default '',
title varchar(50) not null default '' comment '标题',
cover varchar(100) not null default '' comment '封面图片',
content text  comment '文章内容',
forward_id int(11) default 0 comment '转发，原文章ID',
status tinyint(4) not null default 1 comment '文章状态，1正常2封禁（无法查看）3禁止评论4删除',
read_number int(11) not null default 0 comment '文章阅读数，定期更新DB',
praise_number int(11) not null default 0 comment '文章点赞数，定期更新DB',
dislike_number int(11) not null default 0 comment '文章不喜欢数',
tag tinyint(4) not null default 1 comment '文章标签，1未分类，后面大数据用',
updated_at timestamp not null default '2018-10-01 00:00:00',
created_at timestamp not null default current_timestamp,
index uid_article (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '文章表';

create table knowyou_article02 (
id int(11) PRIMARY KEY comment 'baseID * partition + uid % partition',
uid int(11) not null default 0,
username varchar(30) not null default '',
head varchar(100) not null default '',
title varchar(50) not null default '' comment '标题',
cover varchar(100) not null default '' comment '封面图片',
content text  comment '文章内容',
forward_id int(11) default 0 comment '转发，原文章ID',
status tinyint(4) not null default 1 comment '文章状态，1正常2封禁（无法查看）3禁止评论4删除',
read_number int(11) not null default 0 comment '文章阅读数，定期更新DB',
praise_number int(11) not null default 0 comment '文章点赞数，定期更新DB',
dislike_number int(11) not null default 0 comment '文章不喜欢数',
tag tinyint(4) not null default 1 comment '文章标签，1未分类，后面大数据用',
updated_at timestamp not null default '2018-10-01 00:00:00',
created_at timestamp not null default current_timestamp,
index uid_article (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '文章表';

create table knowyou_article03 (
id int(11) PRIMARY KEY comment 'baseID * partition + uid % partition',
uid int(11) not null default 0,
username varchar(30) not null default '',
head varchar(100) not null default '',
title varchar(50) not null default '' comment '标题',
cover varchar(50) not null default '' comment '封面图片',
content text  comment '文章内容',
forward_id int(11) default 0 comment '转发，原文章ID',
status tinyint(4) not null default 1 comment '文章状态，1正常2封禁（无法查看）3禁止评论4删除',
read_number int(11) not null default 0 comment '文章阅读数，定期更新DB',
praise_number int(11) not null default 0 comment '文章点赞数，定期更新DB',
dislike_number int(11) not null default 0 comment '文章不喜欢数',
tag tinyint(4) not null default 1 comment '文章标签，1未分类，后面大数据用',
updated_at timestamp not null default '2018-10-01 00:00:00',
created_at timestamp not null default current_timestamp,
index uid_article (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '文章表';


create table knowyou_article_index00 (
id int(11) comment '索引ID，Redis递增',
article_id int(11) not null default 0,
created_at timestamp not null default current_timestamp,
status tinyint(4) not null default 1 comment '文章状态',
PRIMARY key (`id`),
unique key (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '文章索引表';

create table knowyou_article_index01 (
id int(11) comment '索引ID，Redis递增',
article_id int(11) not null default 0,
created_at timestamp not null default current_timestamp,
status tinyint(4) not null default 1 comment '文章状态',
PRIMARY key (`id`),
unique key (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '文章索引表';

create table knowyou_article_index02 (
id int(11) comment '索引ID，Redis递增',
article_id int(11) not null default 0,
created_at timestamp not null default current_timestamp,
status tinyint(4) not null default 1 comment '文章状态',
PRIMARY key (`id`),
unique key (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '文章索引表';


create table knowyou_comment00 (
id int(11) PRIMARY KEY comment 'baseID * partition + uid % partition',
article_id int(11) not null default 0 comment '被评论文章ID',
uid int(11) not null default 0,
username varchar(50) not null default '' comment '评论用户名',
head varchar(100) not null default '' comment '评论者头像',
content text comment '评论内容',
parent_id int(11) default 0 comment '上一级评论ID',
status tinyint(4) not null default 1 comment '评论状态，1正常2封禁（无法查看）3删除',
praise_number int(11) not null default 0 comment '评论点赞数',
dislike_number int(11) not null default 0 comment '评论不喜欢数',
updated_at timestamp not null default '2018-10-01 00:00:00',
created_at timestamp not null default current_timestamp,
index uid_comment (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '评论表';

create table knowyou_comment01 (
id int(11) PRIMARY KEY comment 'baseID * partition + uid % partition',
article_id int(11) not null default 0 comment '被评论文章ID',
uid int(11) not null default 0,
username varchar(50) not null default '' comment '评论用户名',
head varchar(100) not null default '' comment '评论者头像',
content text comment '评论内容',
parent_id int(11) default 0 comment '上一级评论ID',
status tinyint(4) not null default 1 comment '评论状态，1正常2封禁（无法查看）3删除',
praise_number int(11) not null default 0 comment '评论点赞数',
dislike_number int(11) not null default 0 comment '评论不喜欢数',
updated_at timestamp not null default '2018-10-01 00:00:00',
created_at timestamp not null default current_timestamp,
index uid_comment (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '评论表';

create table knowyou_comment02 (
id int(11) PRIMARY KEY comment 'baseID * partition + uid % partition',
article_id int(11) not null default 0 comment '被评论文章ID',
uid int(11) not null default 0,
username varchar(50) not null default '' comment '评论用户名',
head varchar(100) not null default '' comment '评论者头像',
content text comment '评论内容',
parent_id int(11) default 0 comment '上一级评论ID',
status tinyint(4) not null default 1 comment '评论状态，1正常2封禁（无法查看）3删除',
praise_number int(11) not null default 0 comment '评论点赞数',
dislike_number int(11) not null default 0 comment '评论不喜欢数',
updated_at timestamp not null default '2018-10-01 00:00:00',
created_at timestamp not null default current_timestamp,
index uid_comment (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '评论表';

create table knowyou_comment03 (
id int(11) PRIMARY KEY comment 'baseID * partition + uid % partition',
article_id int(11) not null default 0 comment '被评论文章ID',
uid int(11) not null default 0,
username varchar(50) not null default '' comment '评论用户名',
head varchar(100) not null default '' comment '评论者头像',
content text comment '评论内容',
parent_id int(11) default 0 comment '上一级评论ID',
status tinyint(4) not null default 1 comment '评论状态，1正常2封禁（无法查看）3删除',
praise_number int(11) not null default 0 comment '评论点赞数',
dislike_number int(11) not null default 0 comment '评论不喜欢数',
updated_at timestamp not null default '2018-10-01 00:00:00',
created_at timestamp not null default current_timestamp,
index uid_comment (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '评论表';


create table knowyou_praise00 (
id int(11) PRIMARY KEY AUTO_INCREMENT comment '点赞自增ID',
uid int(11) not null default 0 comment '发起点赞的UID',
article_id int(11) not null default 0 comment '被点赞的文章',
to_uid int(11) not null default 0 comment '被点赞的UID',
status tinyint(4) not null default 1 comment '状态，1点赞2取消',
created_at TIMESTAMP not null default current_timestamp,
updated_at TIMESTAMP not null default current_timestamp,
index praise_number (`article_id`, `to_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '点赞记录表';

create table knowyou_praise01 (
id int(11) PRIMARY KEY AUTO_INCREMENT comment '点赞自增ID',
uid int(11) not null default 0 comment '发起点赞的UID',
article_id int(11) not null default 0 comment '被点赞的文章',
to_uid int(11) not null default 0 comment '被点赞的UID',
status tinyint(4) not null default 1 comment '状态，1点赞2取消',
created_at TIMESTAMP not null default current_timestamp,
updated_at TIMESTAMP not null default current_timestamp,
index praise_number (`article_id`, `to_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '点赞记录表';

create table knowyou_praise02 (
id int(11) PRIMARY KEY AUTO_INCREMENT comment '点赞自增ID',
uid int(11) not null default 0 comment '发起点赞的UID',
article_id int(11) not null default 0 comment '被点赞的文章',
to_uid int(11) not null default 0 comment '被点赞的UID',
status tinyint(4) not null default 1 comment '状态，1点赞2取消',
created_at TIMESTAMP not null default current_timestamp,
updated_at TIMESTAMP not null default current_timestamp,
index praise_number (`article_id`, `to_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '点赞记录表';

create table knowyou_praise03 (
id int(11) PRIMARY KEY AUTO_INCREMENT comment '点赞自增ID',
uid int(11) not null default 0 comment '发起点赞的UID',
article_id int(11) not null default 0 comment '被点赞的文章',
to_uid int(11) not null default 0 comment '被点赞的UID',
status tinyint(4) not null default 1 comment '状态，1点赞2取消',
created_at TIMESTAMP not null default current_timestamp,
updated_at TIMESTAMP not null default current_timestamp,
index praise_number (`article_id`, `to_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '点赞记录表';


create table knowyou_tag (
id int(11) PRIMARY KEY AUTO_INCREMENT comment '标签ID',
type tinyint(4) not null default 1 comment '文章标签，1未分类',
name varchar(50) not null default ''  comment '标签名称',
status tinyint(4) not null default 1 comment '标签状态，1启用2下架3删除',
updated_at timestamp not null default '2018-10-01 00:00:00',
created_at timestamp not null default current_timestamp,
unique key un_type (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '标签表';

/*
微信相关
*/

use wx;

create table wx_record (
  id int(11) AUTO_INCREMENT comment '记录ID',
  msg_id varchar(30) not null default '' comment '消息ID',
  msg_type tinyint(4) not null default 0 comment '消息类型，0未定义',
  to_user_name varchar(30) not null default '' comment '开发者微信号',
  from_user_name varchar(30) not null default '' comment '发送者openid',
  content text comment '文本消息内容',
  event varchar(20) comment '事件',
  media_id varchar(30) comment '图片或语音媒体ID',
  pic_url varchar(100) comment '图片链接',
  created_at timestamp not null default current_timestamp comment '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY (`msg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '微信消息记录表';

create table wx_rules (
  id int(11) AUTO_INCREMENT comment '规则ID',
  key_word varchar(30) not null default '' comment '需要替换的关键词',
  to_word varchar(255) not null default '*' comment '替换目标词',
  status tinyint(4) not null default 1 comment '规则状态，1启用',
  type tinyint(4) not null default 1 comment '关键词',
  created_at timestamp not null default current_timestamp comment '',
  PRIMARY KEY (`id`),
  UNIQUE KEY (`key_word`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '微信规则表';

create table wx_user (
  id int(11) AUTO_INCREMENT comment '',
  open_id varchar(50) not null default '' comment '发送方账号openID',
  status tinyint(4) not null default 1 comment '状态，1订阅者，2已取消',
  created_at timestamp not null default current_timestamp comment '创建时间',
  updated_at timestamp not null default current_timestamp comment '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_openid` (`open_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '微信用户表';