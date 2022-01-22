# userhistory, logs remain after 14 days 


 CREATE TABLE `userhistory` (
  `userid` varchar(1000) NOT NULL,
  `date` date DEFAULT NULL,
  `infected` tinyint(1) DEFAULT NULL,
  KEY `userid` (`userid`),
  CONSTRAINT `userhistory_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 |
