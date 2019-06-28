create table knowyou_suggest (
id int(11) AUTO_INCREMENT comment '消息ID',
name varchar(50) not null default 0 comment '留言名称',
email varchar(30) not null default '' comment '留言邮箱',
content text comment '留言内容',
status tinyint(4) not null default 1 comment '1未回复，2已回复，3删除',
type tinyint(4) not null default 0 comment '留言类型，0未知',
created_at timestamp not null default current_timestamp comment '创建时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '留言表';