CREATE TABLE IF NOT EXISTS `crowdsourcing`.`data` (
    `userid` VARCHAR (1000) NOT NULL,
    `id` VARCHAR (1000),
    `name` VARCHAR(100),
    `address` VARCHAR(1000),
    `latitude` FLOAT(50,30),
    `longitude` FLOAT(50,30),
    PRIMARY KEY (`id`),
    FOREIGN KEY (userid) REFERENCES users(userid),
    UNIQUE INDEX `id_UNIQUE` (`id` ASC))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;