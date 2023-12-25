CREATE DATABASE IF NOT EXISTS desafio_revvo;

USE desafio_revvo;

CREATE TABLE IF NOT EXISTS courses(
    id int unsigned not null auto_increment,
    name varchar(100) not null,
    slug varchar(100) not null,
    slide_image varchar(100) not null,
    description TEXT not null,
    cover_image varchar(100) not null,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    primary key(id)
) Engine=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

INSERT INTO courses(name, slug, slide_image, cover_image, description) VALUES('Javascript', 'javascript', 'javascrip-slide.webp', 'javascript-cover.webp','curso bom');