CREATE TABLE IF NOT EXISTS `crowdsourcing`.`visit_declaration` (
    `userid` VARCHAR (1000) NOT NULL,
    `id` VARCHAR (1000),
    `visit` BOOLEAN,
    `estimation` INT(50),
    `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;