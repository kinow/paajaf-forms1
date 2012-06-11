CREATE DATABASE `paajaf_forms`;

USE `paajaf_forms`;

CREATE TABLE IF NOT EXISTS `organizations` (
    `id` int(11) AUTO_INCREMENT NOT NULL, 
    `title` VARCHAR(100) NOT NULL, 
    `logo_location` VARCHAR(500), 
    `summary` VARCHAR(500) NOT NULL, 
    `founded_date` DATETIME, 
    `employee` VARCHAR(100), 
    `volunteer` VARCHAR(100), 
    `address` VARCHAR(500) NOT NULL, 
    `url` VARCHAR(255), 
    `executive_director` VARCHAR(100), 
    `management_team` VARCHAR(500), 
    `board_director` VARCHAR(100), 
    `missions` VARCHAR(200), 
    `programs` VARCHAR(200), 
    `report_title` VARCHAR(100), 
    `report_message` VARCHAR(100), 
    UNIQUE KEY `title_is_unique` (`title`), 
    PRIMARY KEY(`id`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_bin AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `locations` (
    `id` int(11) AUTO_INCREMENT NOT NULL, 
    `description` VARCHAR(100) NOT NULL, 
    PRIMARY KEY(`id`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_bin AUTO_INCREMENT=3;

INSERT INTO `locations` (`id`, `description`) VALUES(1, 'Christchurch');
INSERT INTO `locations` (`id`, `description`) VALUES(2, 'Auckland');

CREATE TABLE IF NOT EXISTS `categories` (
    `id` int(11) AUTO_INCREMENT NOT NULL, 
    `description` VARCHAR(100) NOT NULL, 
    PRIMARY KEY(`id`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_bin AUTO_INCREMENT = 3;

INSERT INTO `categories` (`id`, `description`) VALUES(1, 'Sample category');
INSERT INTO `categories` (`id`, `description`) VALUES(2, 'Another category');

CREATE TABLE IF NOT EXISTS `projects` (
    `id` int(11) AUTO_INCREMENT NOT NULL, 
    `organization_id` int(11) NOT NULL, 
    `title` VARCHAR(100) NOT NULL, 
    `location_id` int(11) NOT NULL, 
    `category_id` int(11) NOT NULL, 
    `summary` VARCHAR(500) NOT NULL, 
    `issue_problem_challenge` VARCHAR(500) NOT NULL, 
    `how_this_project_helps` VARCHAR(500) NOT NULL, 
    `long_term_impacts` VARCHAR(500) NOT NULL, 
    `message` VARCHAR(500) NOT NULL, 
    `funding_goal` VARCHAR(500) NOT NULL,
    `report_title` VARCHAR(100), 
    `report_message` VARCHAR(100), 
    UNIQUE KEY `title_is_unique` (`title`),
    PRIMARY KEY(`id`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_bin AUTO_INCREMENT=1;

ALTER TABLE `projects`
  ADD CONSTRAINT `projects_fk1` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE;

ALTER TABLE `projects` 
    ADD CONSTRAINT `projects_fk2` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE;

ALTER TABLE `projects`
  ADD CONSTRAINT `projects_fk3` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

CREATE TABLE `project_photos` (
    `id` int(11) AUTO_INCREMENT NOT NULL, 
    `location` VARCHAR(500) NOT NULL, 
    `project_id` int(11) NOT NULL, 
    PRIMARY KEY(`id`)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_bin AUTO_INCREMENT=1;

ALTER TABLE `project_photos`
  ADD CONSTRAINT `project_photos_fk1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;