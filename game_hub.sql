CREATE DATABASE IF NOT EXISTS `game_hub`;

CREATE TABLE IF NOT EXISTS `game_hub`.`users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(31) NOT NULL,
    `password` VARCHAR(31) NOT NULL,
    `email` VARCHAR(31) NOT NULL,
    `role` CHAR(1) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

drop table if exists `game_hub`.`games`;

CREATE TABLE IF NOT EXISTS `game_hub`.`games` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(31) NOT NULL,
    `folder` VARCHAR(31) NOT NULL UNIQUE,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;