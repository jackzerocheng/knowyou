create table wx_user (
  id int(11) AUTO_INCREMENT comment '',
  open_id varchar(50) not null default '' comment '发送方账号openID',
  status tinyint(4) not null default 1 comment '状态，1订阅者，2已取消',
  created_at timestamp not null default current_timestamp comment '创建时间',
  updated_at timestamp not null default current_timestamp comment '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_openid` (`open_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '微信用户表';