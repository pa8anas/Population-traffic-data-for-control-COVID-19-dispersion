CREATE TABLE `infectedusers` (
  `date` date NOT NULL,
  `userid` varchar(255) NOT NULL,
  `infected` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`userid`),
  CONSTRAINT `infectedusers_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 

CREATE EVENT IF NOT EXISTS `Clean_Older_Than_14_Days`
ON SCHEDULE
  EVERY 1 DAY_HOUR
  DO
DELETE FROM infectedusers
    WHERE date < DATE_SUB(NOW(), INTERVAL 14 DAY)