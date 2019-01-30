create table wx_record (
id int(11) AUTO_INCREMENT comment '记录ID',
msg_id varchar(30) not null default '' comment '消息ID',
msg_type tinyint(4) not null default 0 comment '消息类型，0未定义',
to_user_name varchar(30) not null default '' comment '开发者微信号',
from_user_name varchar(30) not null default '' comment '发送者openid',
content text comment '文本消息内容',
media_id varchar(30) comment '图片或语音媒体ID',
pic_url varchar(100) comment '图片链接',
created_at timestamp not null default current_timestamp comment '创建时间',
PRIMARY KEY (`id`),
UNIQUE KEY (`msg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '微信消息记录表';