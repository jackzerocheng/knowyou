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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '用户表';