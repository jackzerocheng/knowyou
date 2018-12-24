create table knowyou_user_admin (
admin_id int(11)  comment '依赖Redis生成',
username varchar(30)  not null default '' comment '管理员昵称',
real_name varchar(30)  not null default '' comment '真实姓名',
password varchar(64)  not null DEFAULT '' comment '算法生成固定64位，hash',
phone varchar(20)  default '',
email varchar(30)  default '',
level tinyint(4) not null default 1 comment '管理员等级，1普通管理员2超级管理员',
last_login_time timestamp not null default '2018-10-01 00:00:00' comment '上次登录时间',
last_login_ip varchar(20) not null default '' comment '上次登录IP',
updated_at timestamp not null DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
created_at timestamp not null DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
PRIMARY KEY (`admin_id`),
UNIQUE key un_un (`username`) using BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '管理员表';

alter table knowyou_user_admin add COLUMN head varchar(200) not null default '@web/img/default_head.png' comment '头像地址';
alter table knowyou_user_admin add COLUMN status tinyint(4) not null default 1 comment '状态1正常，2删除';