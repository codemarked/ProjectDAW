<?php

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'Reberion12211';
$DATABASE_NAME = 'Proiect_DAW';

$connection = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (!$connection) {
    header('Location: maintenance.php');
    exit();
}

mysqli_query($connection,"CREATE TABLE IF NOT EXISTS `accounts` (
	`id` int(21) NOT NULL AUTO_INCREMENT,
  	`username` varchar(50) NOT NULL,
  	`password` varchar(255) NOT NULL,
  	`email` varchar(100) NOT NULL,
  	`role` varchar(30) DEFAULT 'user',
  	`avatar` varchar(100) DEFAULT 'img/default_avatar.png',
  	`banned` int(2) DEFAULT 0,
    `likes` int(10) DEFAULT 0,
    `comments` int(10) DEFAULT 0,
  	`liked_posts` TEXT,
  	`liked_users` TEXT,
    `created_date` BIGINT NOT NULL,
    `lastjoin_date` BIGINT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;");

mysqli_query($connection,"CREATE TABLE IF NOT EXISTS `posts` (
	`id` int(21) NOT NULL AUTO_INCREMENT,
  	`sender` int(21) NOT NULL,
  	`description` varchar(512),
  	`images` varchar(1024) NOT NULL,
  	`visible` int(2) DEFAULT 0,
    `liked_users` TEXT,
    `comments` TEXT,
    `created_date` BIGINT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;");

mysqli_query($connection,"CREATE TABLE IF NOT EXISTS `files` (
	`id` int(21) NOT NULL AUTO_INCREMENT,
  	`post_id` int(21) NOT NULL,
  	`file_name` varchar(128),
  	`file_path` varchar(1024) NOT NULL,
  	`file_size` int(21) DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;");

mysqli_query($connection,"CREATE TABLE IF NOT EXISTS `post_comments` (
	`id` int(21) NOT NULL AUTO_INCREMENT,
  	`sender` int(21) NOT NULL,
  	`text` varchar(512) NOT NULL,
  	`visible` int(2) DEFAULT 1,
    `liked_users` TEXT,
    `created_date` BIGINT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;");

mysqli_query($connection,"CREATE TABLE IF NOT EXISTS `profile_comments` (
	`id` int(21) NOT NULL AUTO_INCREMENT,
  	`sender` int(21) NOT NULL,
  	`text` varchar(512) NOT NULL,
  	`visible` int(2) DEFAULT 1,
    `liked_users` TEXT,
    `created_date` BIGINT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;");
?>