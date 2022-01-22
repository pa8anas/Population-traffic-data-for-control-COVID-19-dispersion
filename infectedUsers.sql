# infectedusers table, active infected users


 CREATE TABLE `infectedusers` (
  `date` date NOT NULL,
  `userID` varchar(255) NOT NULL,
  `infected` tinyint(1) NOT NULL,
  PRIMARY KEY (`userID`),
  CONSTRAINT `infectedusers_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 |



# Event for deleting entries after 14 days

CREATE EVENT IF NOT EXISTS `Delete_log_after_14days`
ON SCHEDULE
  EVERY 1 DAY
  DO
DELETE FROM infectedusers
    WHERE date < DATE_SUB(NOW(), INTERVAL 14 DAY)
