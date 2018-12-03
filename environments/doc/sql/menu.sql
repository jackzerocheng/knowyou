create table knowyou_menu (
id int(11) AUTO_INCREMENT comment '菜单名称',
name varchar(20) not null default '' comment '菜单名称',
level tinyint(4) not null default 0 comment '菜单等级，1一级菜单',
parent_id int(11)  comment '父级菜单',
url varchar(200) not null default '' comment '菜单链接',
status tinyint(4) not null default 1 comment '状态，1正常2停用',
weight int(10) not null default 1 comment '菜单权重,越小排越前面',
updated_at timestamp not null default '2018-10-01 00:00:00' comment '更新时间',
created_at timestamp not null default current_timestamp comment '创建时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '菜单表';