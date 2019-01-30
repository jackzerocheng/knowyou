create table wx_rules (
  id int(11) AUTO_INCREMENT comment '规则ID',
  key_word varchar(30) not null default '' comment '需要替换的关键词',
  to_word varchar(255) not null default '*' comment '替换目标词',
  status tinyint(4) not null default 1 comment '规则状态，1启用',
  created_at timestamp not null default current_timestamp comment '',
  PRIMARY KEY (`id`),
  UNIQUE KEY (`key_word`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '微信规则表';