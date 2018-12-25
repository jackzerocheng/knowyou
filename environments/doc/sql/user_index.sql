create table knowyou_user_index00 (
id int(11) comment '索引ID，Redis递增',
uid int(11) not null default 0 comment '用户ID',
created_at timestamp not null default current_timestamp,
PRIMARY KEY (`id`),
UNIQUE KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '用户索引表';