create table knowyou_praise00 (
id int(11) PRIMARY KEY AUTO_INCREMENT comment '点赞自增ID',
uid int(11) not null default 0 comment '发起点赞的UID',
article_id int(11) not null default 0 comment '被点赞的文章',
to_uid int(11) not null default 0 comment '被点赞的UID',
status tinyint(4) not null default 1 comment '状态，1点赞2取消',
created_at date not null default '2018-10-01 00:00:00',
updated_at date not null default CURRENT_TIMESTAMP,
index praise_number (`article_id`, `to_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '点赞记录表';