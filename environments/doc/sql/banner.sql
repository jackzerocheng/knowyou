create table knowyou_banner (
id int(11) AUTO_INCREMENT comment '运营位编号',
platform_id tinyint(4) not null default 1 comment '平台编号，1web，2安卓,3ios',
name varchar(50) not null default '' comment '运营位名称',
img varchar(200) default '' comment '图片链接',
link varchar(200) default '' comment '链接地址',
status tinyint(4) not null default 1 comment '状态，1正常2停用',
type tinyint(4) not null default 1 comment '类型，1普通运营位2广告位',
start_at date not null default '2018-10-01' comment '开始时间',
end_at date not null default '2018-10-01' comment '结束时间',
updated_at timestamp not null default '2018-10-01 00:00:00' comment '更新时间',
created_at timestamp not null default current_timestamp comment '创建时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '运营位';