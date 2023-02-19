CREATE DATABASE IF NOT EXISTS `game_hub`;
USE `game_hub`;

CREATE TABLE IF NOT EXISTS `game_hub`.`users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(31) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(31) NOT NULL UNIQUE,
    `role` CHAR(1) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `game_hub`.`games` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(31) NOT NULL UNIQUE,
    `folder` VARCHAR(31) NOT NULL UNIQUE,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `game_hub`.`tags` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(31) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- A game can have multiple tags, and a tag can be used for multiple games.
CREATE TABLE IF NOT EXISTS `game_hub`.`game_tags_rel` (
    `game_id` INT NOT NULL,
    `tag_id` INT NOT NULL,
    PRIMARY KEY (`game_id`, `tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;