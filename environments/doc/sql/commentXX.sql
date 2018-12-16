create table knowyou_comment03 (
id int(11) PRIMARY KEY comment 'baseID * partition + uid % partition',
article_id int(11) not null default 0 comment '被评论文章ID',
uid int(11) not null default 0,
content text comment '评论内容',
parent_id int(11) default 0 comment '上一级评论ID',
status tinyint(4) not null default 1 comment '评论状态，1正常2封禁（无法查看）3删除',
praise_number int(11) not null default 0 comment '评论点赞数',
dislike_number int(11) not null default 0 comment '评论不喜欢数',
updated_at timestamp not null default '2018-10-01 00:00:00',
created_at timestamp not null default current_timestamp,
index uid_comment (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '评论表';