create table knowyou_suggest (
id int(11) AUTO_INCREMENT comment '消息ID',
uid int(11) not null default 0 comment '留言用户ID',
content varchar(300) not null default '' comment '留言内容',
created_at timestamp not null default current_timestamp comment '创建时间',
status tinyint(4) not null default 1 comment '1未回复，2已回复，3删除',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '留言表';