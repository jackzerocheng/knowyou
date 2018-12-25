create table knowyou_article_index00 (
id int(11) comment '索引ID，Redis递增',
article_id int(11) not null default 0,
created_at timestamp not null default current_timestamp,
PRIMARY key (`id`),
unique key (`article_id`),
index search_by_id (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '文章索引表';