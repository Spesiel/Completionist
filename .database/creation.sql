-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema completionistv2
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `completionistv2` ;

-- -----------------------------------------------------
-- Schema completionistv2
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `completionistv2` DEFAULT CHARACTER SET latin1 ;
USE `completionistv2` ;

-- -----------------------------------------------------
-- Table `completionistv2`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `completionistv2`.`users` ;

CREATE TABLE IF NOT EXISTS `completionistv2`.`users` (
  `userid` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `useridorigin` BIGINT(20) UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `hash` VARCHAR(127) NOT NULL,
  `email` VARCHAR(255) NULL,
  `modification` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`userid`, `useridorigin`, `name`),
  INDEX `useridorigin_idx` (`useridorigin` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `completionistv2`.`games`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `completionistv2`.`games` ;

CREATE TABLE IF NOT EXISTS `completionistv2`.`games` (
  `gameid` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `gameidorigin` BIGINT(20) UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `link` VARCHAR(127) NULL,
  `comment` TEXT NULL,
  `modification` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userid` BIGINT(20) UNSIGNED NOT NULL,
  `locked` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`gameid`, `gameidorigin`, `name`, `userid`),
  INDEX `gameidorigin_idx` (`gameidorigin` ASC),
  INDEX `fk_games_users_idx` (`userid` ASC),
  CONSTRAINT `fk_games_users`
    FOREIGN KEY (`userid`)
    REFERENCES `completionistv2`.`users` (`useridorigin`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `completionistv2`.`bookmarks`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `completionistv2`.`bookmarks` ;

CREATE TABLE IF NOT EXISTS `completionistv2`.`bookmarks` (
  `userid` BIGINT(20) UNSIGNED NOT NULL,
  `gameid` BIGINT(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`userid`, `gameid`),
  INDEX `fk_bookmarks_games1_idx` (`gameid` ASC),
  CONSTRAINT `fk_bookmarks_users1`
    FOREIGN KEY (`userid`)
    REFERENCES `completionistv2`.`users` (`useridorigin`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bookmarks_games1`
    FOREIGN KEY (`gameid`)
    REFERENCES `completionistv2`.`games` (`gameidorigin`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `completionistv2`.`sessions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `completionistv2`.`sessions` ;

CREATE TABLE IF NOT EXISTS `completionistv2`.`sessions` (
  `sessionid` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `userid` BIGINT(20) UNSIGNED NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `startdate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `enddate` TIMESTAMP NULL,
  `active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`sessionid`, `userid`),
  INDEX `fk_sessions_users1_idx` (`userid` ASC),
  INDEX `token_idx` (`token` ASC),
  CONSTRAINT `fk_sessions_users1`
    FOREIGN KEY (`userid`)
    REFERENCES `completionistv2`.`users` (`useridorigin`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `completionistv2`.`friends`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `completionistv2`.`friends` ;

CREATE TABLE IF NOT EXISTS `completionistv2`.`friends` (
  `friendid` BIGINT UNSIGNED NOT NULL,
  `userid` BIGINT UNSIGNED NOT NULL,
  `status` TINYINT(1) NULL,
  `date` TIMESTAMP NULL,
  PRIMARY KEY (`friendid`, `userid`),
  INDEX `fk_friends_users2_idx` (`userid` ASC),
  CONSTRAINT `fk_friends_users1`
    FOREIGN KEY (`friendid`)
    REFERENCES `completionistv2`.`users` (`useridorigin`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_friends_users2`
    FOREIGN KEY (`userid`)
    REFERENCES `completionistv2`.`users` (`useridorigin`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `completionistv2`.`messages`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `completionistv2`.`messages` ;

CREATE TABLE IF NOT EXISTS `completionistv2`.`messages` (
  `messageid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `touserid` BIGINT UNSIGNED NOT NULL,
  `fromuserid` BIGINT UNSIGNED NOT NULL,
  `title` VARCHAR(255) NULL,
  `body` TEXT NOT NULL,
  `sent` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `opened` TIMESTAMP NULL,
  `deleted` TIMESTAMP NULL,
  PRIMARY KEY (`messageid`, `touserid`, `fromuserid`),
  INDEX `fk_messages_users1_idx` (`fromuserid` ASC),
  INDEX `fk_messages_users2_idx` (`touserid` ASC),
  CONSTRAINT `fk_messages_usersfrom`
    FOREIGN KEY (`fromuserid`)
    REFERENCES `completionistv2`.`users` (`useridorigin`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_messages_usersto`
    FOREIGN KEY (`touserid`)
    REFERENCES `completionistv2`.`users` (`useridorigin`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `completionistv2`;

DELIMITER $$

USE `completionistv2`$$
DROP TRIGGER IF EXISTS `completionistv2`.`users_BEFORE_INSERT` $$
USE `completionistv2`$$
CREATE DEFINER = CURRENT_USER TRIGGER `completionistv2`.`users_BEFORE_INSERT` BEFORE INSERT ON `users` FOR EACH ROW
BEGIN
	IF(NEW.useridorigin IS NULL) THEN
		SET NEW.useridorigin = (SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'completionistv2' AND TABLE_NAME = 'users');
    END IF;
END$$


USE `completionistv2`$$
DROP TRIGGER IF EXISTS `completionistv2`.`users_BEFORE_UPDATE` $$
USE `completionistv2`$$
CREATE DEFINER = CURRENT_USER TRIGGER `completionistv2`.`users_BEFORE_UPDATE` BEFORE UPDATE ON `users` FOR EACH ROW
BEGIN
	SET NEW.modification = CURRENT_TIMESTAMP;
END$$


USE `completionistv2`$$
DROP TRIGGER IF EXISTS `completionistv2`.`games_BEFORE_INSERT` $$
USE `completionistv2`$$
CREATE DEFINER = CURRENT_USER TRIGGER `completionistv2`.`games_BEFORE_INSERT` BEFORE INSERT ON `games` FOR EACH ROW
BEGIN
	IF(NEW.gameidorigin IS NULL) THEN
		SET NEW.gameidorigin = (SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'completionistv2' AND TABLE_NAME = 'games');
    END IF;
END$$


USE `completionistv2`$$
DROP TRIGGER IF EXISTS `completionistv2`.`games_BEFORE_UPDATE` $$
USE `completionistv2`$$
CREATE DEFINER = CURRENT_USER TRIGGER `completionistv2`.`games_BEFORE_UPDATE` BEFORE UPDATE ON `games` FOR EACH ROW
BEGIN
	SET NEW.modification = CURRENT_TIMESTAMP;
END$$


USE `completionistv2`$$
DROP TRIGGER IF EXISTS `completionistv2`.`sessions_BEFORE_UPDATE` $$
USE `completionistv2`$$
CREATE DEFINER = CURRENT_USER TRIGGER `completionistv2`.`sessions_BEFORE_UPDATE` BEFORE UPDATE ON `sessions` FOR EACH ROW
BEGIN
	IF NEW.active <> OLD.active THEN
		SET NEW.enddate = CURRENT_TIMESTAMP;
	END IF;
END$$


DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
