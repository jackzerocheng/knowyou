create table knowyou_tag (
id int(11) PRIMARY KEY AUTO_INCREMENT comment '标签ID',
type tinyint(4) not null default 1 comment '文章标签，1未分类',
name varchar(50) not null default ''  comment '标签名称',
status tinyint(4) not null default 1 comment '标签状态，1启用2下架3删除',
updated_at timestamp not null default '2018-10-01 00:00:00',
created_at timestamp not null default current_timestamp,
unique key un_type (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '评论表';