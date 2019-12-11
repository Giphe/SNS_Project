
drop table SNS_Project.m_group;
create table SNS_Project.m_group(
	group_id int(8),
	user_count int(16),
	koukai_flg int(1),
	created datetime,
	modified datetime
);

drop table SNS_Project.m_category;
create table SNS_Project.m_category(
	category_id int(8),
	category_name varchar(255),
	user_count int(16),
	koukai_flg int(1),
	created datetime
);

drop table SNS_Project.t_users;
create table SNS_Project.t_users(
	id int not null auto_increment primary key,
	email varchar(255) unique,
	user_name varchar(20),
	password varchar(255),
	icon varchar(100),
	address varchar(100),
	tel varchar(20),
	shokai varchar(60),
	su_flg int(1) default 0,
	web_flg int(1) default 0,
	premium_flg int(1) default 0,
	koukai_flg int(1) default 0,
	created datetime,
	created_by varchar(255),
	modified datetime,
	modified_by varchar(255)
);

drop table SNS_Project.t_usergroup;
create table SNS_Project.t_usergroup(
	id int(50),
	group_id int(50),
	created datetime,
	created_by varchar(255)
);

drop table SNS_Project.t_wisp;
create table SNS_Project.t_wisp(
	id int not null auto_increment primary key,
	user_id int(50),
	user_name varchar(255),
	body text,
	category_id int(50),
	del_flg int(1) default 0,
	koukai_flg int(1),
	post varchar(255),
	comment varchar(255)
);

drop table SNS_Project.t_follow;
create table SNS_Project.t_follow(
	user_id int(50),
	follower_id int(50),
	follower_name varchar(255)
);

drop table SNS_Project.t_postlike;
create table SNS_Project.t_postlike(
	topics_id int(50),
	user_id int(50)
);

drop table SNS_Project.t_topics;
create table SNS_Project.t_topics(
	id int not null auto_increment primary key,
	kubun int(1),
	category_id int(2),
	title text,
	body text,
	koukai_date datetime,
	start_date datetime,
	end_date datetime,
	created datetime,
	created_by varchar(255),
	modified datetime,
	modified_by varchar(255)
);

drop table SNS_Project.t_topicsimg;
create table SNS_Project.t_topicsimg(
	topics_id int(50),
	topics_img varchar(255),
	created datetime
);

drop table SNS_Project.t_categorygroup;
create table SNS_Project.t_categorygroup(
	caegory_id int(50),
	group_id int(50),
	category_img varchar(255)
);

drop table SNS_Project.t_todos;
create table SNS_Project.t_todos(
	todo_id int not null auto_increment primary key,
	state tinyint(1) default 0, 
	body text,
	title text,
	user_id int,
	user_name varchar(255),
	created datetime
);

drop table SNS_Project.t_comments;
create table SNS_Project.t_comments(
	comment_id int not null auto_increment primary key,
	todo_id int not null,
	state tinyint(1) default 0, 
	body text,
	user_id int,
	user_name varchar(255),
	created datetime
);

