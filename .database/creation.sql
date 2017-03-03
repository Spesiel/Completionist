-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema completionist
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `completionist` ;

-- -----------------------------------------------------
-- Schema completionist
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `completionist` DEFAULT CHARACTER SET latin1 ;
USE `completionist` ;

-- -----------------------------------------------------
-- Table `completionist`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `completionist`.`users` ;

CREATE TABLE IF NOT EXISTS `completionist`.`users` (
  `userid` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `useridorigin` BIGINT(20) UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `hash` VARCHAR(127) NOT NULL,
  `email` VARCHAR(255) NULL,
  `modification` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` TINYINT(1) NOT NULL DEFAULT 1,
  `role` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`userid`, `useridorigin`, `name`),
  INDEX `useridorigin_idx` (`useridorigin` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `completionist`.`games`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `completionist`.`games` ;

CREATE TABLE IF NOT EXISTS `completionist`.`games` (
  `gameid` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `gameidorigin` BIGINT(20) UNSIGNED NOT NULL,
  `gameidrelated` BIGINT(20) UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `link` VARCHAR(127) NULL,
  `comment` TEXT NULL,
  `modification` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userid` BIGINT(20) UNSIGNED NOT NULL,
  `locked` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`gameid`, `gameidorigin`, `name`, `userid`, `gameidrelated`),
  INDEX `gameidorigin_idx` (`gameidorigin` ASC),
  INDEX `fk_games_users_idx` (`userid` ASC),
  INDEX `fk_games_games_idx` (`gameidrelated` ASC),
  CONSTRAINT `fk_games_users`
    FOREIGN KEY (`userid`)
    REFERENCES `completionist`.`users` (`useridorigin`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_games_games`
    FOREIGN KEY (`gameidrelated`)
    REFERENCES `completionist`.`games` (`gameidorigin`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `completionist`.`bookmarks`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `completionist`.`bookmarks` ;

CREATE TABLE IF NOT EXISTS `completionist`.`bookmarks` (
  `userid` BIGINT(20) UNSIGNED NOT NULL,
  `gameid` BIGINT(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`userid`, `gameid`),
  INDEX `fk_bookmarks_games1_idx` (`gameid` ASC),
  CONSTRAINT `fk_bookmarks_users1`
    FOREIGN KEY (`userid`)
    REFERENCES `completionist`.`users` (`useridorigin`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bookmarks_games1`
    FOREIGN KEY (`gameid`)
    REFERENCES `completionist`.`games` (`gameidorigin`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `completionist`.`sessions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `completionist`.`sessions` ;

CREATE TABLE IF NOT EXISTS `completionist`.`sessions` (
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
    REFERENCES `completionist`.`users` (`useridorigin`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `completionist`.`friends`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `completionist`.`friends` ;

CREATE TABLE IF NOT EXISTS `completionist`.`friends` (
  `userid` BIGINT UNSIGNED NOT NULL,
  `friendid` BIGINT UNSIGNED NOT NULL,
  `status` TINYINT(1) NOT NULL DEFAULT 0,
  `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`userid`, `friendid`),
  INDEX `fk_friends_users2_idx` (`userid` ASC),
  CONSTRAINT `fk_friends_users1`
    FOREIGN KEY (`friendid`)
    REFERENCES `completionist`.`users` (`useridorigin`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_friends_users2`
    FOREIGN KEY (`userid`)
    REFERENCES `completionist`.`users` (`useridorigin`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `completionist`.`messages`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `completionist`.`messages` ;

CREATE TABLE IF NOT EXISTS `completionist`.`messages` (
  `messageid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `fromuserid` BIGINT UNSIGNED NOT NULL,
  `touserid` BIGINT UNSIGNED NOT NULL,
  `title` VARCHAR(255) NULL,
  `body` TEXT NOT NULL,
  `sent` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `opened` TIMESTAMP NULL,
  `deleted` TIMESTAMP NULL,
  PRIMARY KEY (`messageid`, `fromuserid`, `touserid`),
  INDEX `fk_messages_users1_idx` (`fromuserid` ASC),
  INDEX `fk_messages_users2_idx` (`touserid` ASC),
  CONSTRAINT `fk_messages_usersfrom`
    FOREIGN KEY (`fromuserid`)
    REFERENCES `completionist`.`users` (`useridorigin`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_messages_usersto`
    FOREIGN KEY (`touserid`)
    REFERENCES `completionist`.`users` (`useridorigin`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `completionist`;

DELIMITER $$

USE `completionist`$$
DROP TRIGGER IF EXISTS `completionist`.`users_BEFORE_INSERT` $$
USE `completionist`$$
CREATE DEFINER = CURRENT_USER TRIGGER `completionist`.`users_BEFORE_INSERT` BEFORE INSERT ON `users` FOR EACH ROW
BEGIN
	IF(NEW.useridorigin IS NULL) THEN
		SET NEW.useridorigin = (SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'completionist' AND TABLE_NAME = 'users');
    END IF;
END$$


USE `completionist`$$
DROP TRIGGER IF EXISTS `completionist`.`users_BEFORE_UPDATE` $$
USE `completionist`$$
CREATE DEFINER = CURRENT_USER TRIGGER `completionist`.`users_BEFORE_UPDATE` BEFORE UPDATE ON `users` FOR EACH ROW
BEGIN
	SET NEW.modification = CURRENT_TIMESTAMP;
END$$


USE `completionist`$$
DROP TRIGGER IF EXISTS `completionist`.`games_BEFORE_INSERT` $$
USE `completionist`$$
CREATE DEFINER = CURRENT_USER TRIGGER `completionist`.`games_BEFORE_INSERT` BEFORE INSERT ON `games` FOR EACH ROW
BEGIN
	IF(NEW.gameidorigin IS NULL) THEN
		SET NEW.gameidorigin = (SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'completionist' AND TABLE_NAME = 'games');
    END IF;

	IF(NEW.gameidrelated IS NULL) THEN
		SET NEW.gameidrelated = (SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'completionist' AND TABLE_NAME = 'games');
    END IF;
END$$


USE `completionist`$$
DROP TRIGGER IF EXISTS `completionist`.`games_BEFORE_UPDATE` $$
USE `completionist`$$
CREATE DEFINER = CURRENT_USER TRIGGER `completionist`.`games_BEFORE_UPDATE` BEFORE UPDATE ON `games` FOR EACH ROW
BEGIN
	SET NEW.modification = CURRENT_TIMESTAMP;
END$$


USE `completionist`$$
DROP TRIGGER IF EXISTS `completionist`.`sessions_BEFORE_UPDATE` $$
USE `completionist`$$
CREATE DEFINER = CURRENT_USER TRIGGER `completionist`.`sessions_BEFORE_UPDATE` BEFORE UPDATE ON `sessions` FOR EACH ROW
BEGIN
	IF NEW.active <> OLD.active THEN
		SET NEW.enddate = CURRENT_TIMESTAMP;
	END IF;
END$$


USE `completionist`$$
DROP TRIGGER IF EXISTS `completionist`.`friends_BEFORE_UPDATE` $$
USE `completionist`$$
CREATE DEFINER = CURRENT_USER TRIGGER `completionist`.`friends_BEFORE_UPDATE` BEFORE UPDATE ON `friends` FOR EACH ROW
BEGIN
	IF(OLD.status <> NEW.status) THEN
		SET NEW.date = CURRENT_TIMESTAMP;
    END IF;
END$$


DELIMITER ;
SET SQL_MODE = '';
GRANT USAGE ON *.* TO completionist;
 DROP USER completionist;
SET SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';
CREATE USER 'completionist' IDENTIFIED BY 'default';

GRANT ALL ON `completionist`.* TO 'completionist';

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
