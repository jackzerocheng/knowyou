create table knowyou_article_indexXX (
id int(11) auto_increment,
article_id int(11) not null default 0,
created_at timestamp not null default current_timestamp,
primary key (`id`),
index search_by_id (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 comment = '文章索引表';