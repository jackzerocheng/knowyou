create table knowyou_user_level (
uid int(11) comment '用户ID',
level tinyint(4) not null default 1 comment '用户等级',
now_experience int(10) not null default 0 comment '当前等级累计经验',
updated_at timestamp not null default '2018-10-01 00:00:00',
created_at timestamp not null default current_timestamp,
PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '等级表';