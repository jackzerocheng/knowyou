create table wx_user (
  id int(11) AUTO_INCREMENT comment '',
  to_user_name varchar(50) not null default '' comment '开发者微信号',
  from_user_name varchar(50) not null default '' comment '发送方账号openID',
  create_time int(11) not null default 0 comment '消息创建时间',
  msg_type varchar(10) not null default '' comment '消息类型',
  event varchar(20) not null default '' comment '事件',
  status tinyint(4) not null default 1 comment '状态，1订阅者，2已取消',
  created_at timestamp not null default current_timestamp comment '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '微信用户表';