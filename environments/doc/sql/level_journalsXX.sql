create table knowyou_user_level_journals00 (
uid int(11) comment '用户ID',
number int(10) not null default 0 comment '获得经验值',
type tinyint(4) not null default 1 comment '1签到，2活动',
updated_at timestamp not null default '2018-10-01 00:00:00',
created_at timestamp not null default current_timestamp,
PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '等级流水表';