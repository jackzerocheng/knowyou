create table knowyou_article03 (
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