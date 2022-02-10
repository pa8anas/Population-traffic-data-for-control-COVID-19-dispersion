CREATE TABLE IF NOT EXISTS `crowdsourcing`.`userHistory` (
    `userid` VARCHAR (1000) NOT NULL,
    `date` DATE,
    `infected` BOOLEAN
  )
    DEFAULT CHARACTER SET = utf8;
