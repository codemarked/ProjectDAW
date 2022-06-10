<?php

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'password';
$DATABASE_NAME = 'Proiect_DAW';

$TABLE_ACCOUNTS = 'accounts';
$TABLE_POSTS = 'posts';
$TABLE_FILES = 'files';
$TABLE_COMMENTS_POST = 'post_comments';
$TABLE_COMMENTS_PROFILE = 'profile_comments';
$TABLE_LIKES_POST = 'post_likes';
$TABLE_LIKES_PROFILE = 'profile_likes';

$connection = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (!$connection) {
    header('Location: maintenance.php');
    exit();
}

mysqli_query($connection,"CREATE TABLE IF NOT EXISTS `$TABLE_ACCOUNTS` (
	`id` int(21) NOT NULL AUTO_INCREMENT,
  	`username` varchar(50) NOT NULL,
  	`password` varchar(255) NOT NULL,
  	`email` varchar(100) NOT NULL,
  	`role` varchar(30) DEFAULT 'user',
  	`avatar` varchar(100) DEFAULT 'img/default_avatar.png',
  	`banned` int(2) DEFAULT 0,
    `created_date` BIGINT NOT NULL,
    `lastjoin_date` BIGINT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;");

mysqli_query($connection,"CREATE TABLE IF NOT EXISTS `$TABLE_POSTS` (
	`id` int(21) NOT NULL AUTO_INCREMENT,
  	`sender` int(21) NOT NULL,
  	`description` varchar(512),
  	`visible` int(2) DEFAULT 0,
    `created_date` BIGINT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;");

mysqli_query($connection,"CREATE TABLE IF NOT EXISTS `$TABLE_FILES` (
	`id` int(21) NOT NULL AUTO_INCREMENT,
  	`post_id` int(21) NOT NULL,
  	`file_name` varchar(128),
  	`file_path` varchar(1024) NOT NULL,
  	`file_size` int(21) DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;");

mysqli_query($connection,"CREATE TABLE IF NOT EXISTS `$TABLE_LIKES_POST` (
	`id` int(21) NOT NULL AUTO_INCREMENT,
  	`post_id` int(21) NOT NULL,
  	`sender` int(21) NOT NULL,
  	`visible` int(2) DEFAULT 1,
    `created_date` BIGINT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;");

mysqli_query($connection,"CREATE TABLE IF NOT EXISTS `$TABLE_LIKES_PROFILE` (
	`id` int(21) NOT NULL AUTO_INCREMENT,
  	`profile_id` int(21) NOT NULL,
  	`sender` int(21) NOT NULL,
  	`text` varchar(512) NOT NULL,
  	`visible` int(2) DEFAULT 1,
    `created_date` BIGINT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;");

mysqli_query($connection,"CREATE TABLE IF NOT EXISTS `$TABLE_COMMENTS_POST` (
	`id` int(21) NOT NULL AUTO_INCREMENT,
  	`post_id` int(21) NOT NULL,
  	`sender` int(21) NOT NULL,
  	`text` varchar(512) NOT NULL,
  	`visible` int(2) DEFAULT 1,
    `created_date` BIGINT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;");

mysqli_query($connection,"CREATE TABLE IF NOT EXISTS `$TABLE_COMMENTS_PROFILE` (
	`id` int(21) NOT NULL AUTO_INCREMENT,
  	`profile_id` int(21) NOT NULL,
  	`sender` int(21) NOT NULL,
  	`text` varchar(512) NOT NULL,
  	`visible` int(2) DEFAULT 1,
    `created_date` BIGINT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;");
?>