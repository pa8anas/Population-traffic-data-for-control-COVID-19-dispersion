CREATE SCHEMA IF NOT EXISTS `crowdsourcing` DEFAULT CHARACTER SET utf8 ;
USE `crowdsourcing` ;

DROP TABLE IF EXISTS `crowdsourcing`.`users` ;
CREATE TABLE IF NOT EXISTS `crowdsourcing`.`users` (
  `userid` VARCHAR(255) NOT NULL,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `type` TINYINT(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`userid`),
  UNIQUE INDEX `userid_UNIQUE` (`userid` ASC),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

INSERT INTO `crowdsourcing`.`users` (userid, username, password, email, type) VALUES ('bjGbnD/wvD0ny/KJP11dqiKUCU3yZHgWz/p2tg==', 'admin', 'acb8415887ed5875330bfac6a3a5a88b', 'pathanas@ceid.upatras.gr', 0);