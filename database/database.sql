CREATE DATABASE IF NOT EXISTS desafio_revvo;

USE desafio_revvo;

CREATE TABLE IF NOT EXISTS courses(
    id int unsigned not null auto_increment,
    name varchar(100) not null,
    slug varchar(100) not null,
    slide_image varchar(100) default NULL,
    description TEXT not null,
    cover_image varchar(100) default NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    primary key(id)
) Engine=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

insert into courses(name, slug, description) values('Javascript', 'javascript', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur rutrum purus feugiat, auctor nunc ac, faucibus libero. Fusce sodales consequat lorem eu eleifend. Nam consequat');
insert into courses(name, slug, description) values('PhP', 'php', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur rutrum purus feugiat, auctor nunc ac, faucibus libero. Fusce sodales consequat lorem eu eleifend. Nam consequat');
insert into courses(name, slug, description) values('C Sharp', 'c-sharp', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur rutrum purus feugiat, auctor nunc ac, faucibus libero. Fusce sodales consequat lorem eu eleifend. Nam consequat');
insert into courses(name, slug, description) values('Java', 'java', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur rutrum purus feugiat, auctor nunc ac, faucibus libero. Fusce sodales consequat lorem eu eleifend. Nam consequat');
insert into courses(name, slug, description) values('Go Lang', 'go-lang', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur rutrum purus feugiat, auctor nunc ac, faucibus libero. Fusce sodales consequat lorem eu eleifend. Nam consequat');
insert into courses(name, slug, description) values('C', 'c', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur rutrum purus feugiat, auctor nunc ac, faucibus libero. Fusce sodales consequat lorem eu eleifend. Nam consequat');
insert into courses(name, slug, description) values('Delphi', 'delphi', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur rutrum purus feugiat, auctor nunc ac, faucibus libero. Fusce sodales consequat lorem eu eleifend. Nam consequat');
CREATE TABLE IF NOT EXISTS users(
    id int unsigned not null auto_increment,
    first_name varchar(50) not null,
    last_name varchar(50) not null,
    email varchar(100) not null,
    password varchar(255) not null,
    primary key(id)
) Engine=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

insert into users(first_name, last_name, email, password) 
    values('Carlos', 'Silva', 'carlos@gmail.com', '$2y$10$4DXoe.rx1O74QSGh2kDYfOeKk4n3XraNXyvhx7VMsLw2S/5KckGI6');

CREATE TABLE IF NOT EXISTS users_courses(
	id int unsigned not null auto_increment,
    user_id int unsigned not null,
    course_id int unsigned not null,
    primary key(id),
    constraint fk_user_id foreign key(user_id) references users(id),
    constraint fk_course_id foreign key(course_id) references courses(id)
) Engine=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

insert into users_courses(user_id,course_id) values(1,1);
insert into users_courses(user_id,course_id) values(1,2);
insert into users_courses(user_id,course_id) values(1,3);
insert into users_courses(user_id,course_id) values(1,4);
insert into users_courses(user_id,course_id) values(1,5);
insert into users_courses(user_id,course_id) values(1,6);
insert into users_courses(user_id,course_id) values(1,7);





