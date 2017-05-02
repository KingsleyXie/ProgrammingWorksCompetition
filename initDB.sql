CREATE DATABASE IF NOT EXISTS Competition DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE Competition;

CREATE TABLE IF NOT EXISTS `productionTeams`(
  `teamID` INTEGER NOT NULL AUTO_INCREMENT,
  `teamName` VARCHAR(90) NOT NULL,
  `registerTime` TIMESTAMP NOT NULL,
  `pwdSHA256` VARCHAR(90) NOT NULL,
  PRIMARY KEY(`teamID`),
  UNIQUE KEY `teamName_UNIQUE`(`teamName`),
  UNIQUE KEY `teamID_UNIQUE`(`teamID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 AUTO_INCREMENT=1001;

CREATE TABLE IF NOT EXISTS `students`(
  `studentID` INTEGER NOT NULL AUTO_INCREMENT,
  `studentName` VARCHAR(90) NOT NULL,
  `studentNo` VARCHAR(90) NOT NULL,
  `contact` VARCHAR(90) NOT NULL,
  `campus` VARCHAR(90) NOT NULL,
  `college` VARCHAR(90) NOT NULL,
  `major` VARCHAR(90) NOT NULL,
  `grade` VARCHAR(90) NOT NULL,
  `teamID` INTEGER NOT NULL,
  `teamCharacter` VARCHAR(90) NOT NULL,
  PRIMARY KEY(`studentID`),
  UNIQUE KEY `studentID_UNIQUE`(`studentID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `creativityTeams`(
  `teamID` INTEGER NOT NULL AUTO_INCREMENT,
  `teamName` VARCHAR(90) NOT NULL,
  `registerTime` TIMESTAMP NOT NULL,
  `pwdSHA256` VARCHAR(90) NOT NULL,
  PRIMARY KEY(`teamID`),
  UNIQUE KEY `teamName_UNIQUE`(`teamName`),
  UNIQUE KEY `teamID_UNIQUE`(`teamID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 AUTO_INCREMENT=2001;


INSERT INTO `productionTeams` (`teamName`, `registerTime`, `pwdSHA256`)
  VALUES
    ('怒斥香港记者队', NOW(), '124640BF2792A0CDCE2C04E13326D67BF013BAC6CE546616B04888E7C4E68631'),
    ('视察二院队', NOW(), '124640BF2792A0CDCE2C04E13326D67BF013BAC6CE546616B04888E7C4E68631'),
    ('华莱士访谈队', NOW(), '124640BF2792A0CDCE2C04E13326D67BF013BAC6CE546616B04888E7C4E68631');

INSERT INTO `creativityTeams` (`teamName`, `registerTime`, `pwdSHA256`)
  VALUES
    ('怒斥香港记者队', NOW(), '124640BF2792A0CDCE2C04E13326D67BF013BAC6CE546616B04888E7C4E68631'),
    ('视察二院队', NOW(), '124640BF2792A0CDCE2C04E13326D67BF013BAC6CE546616B04888E7C4E68631'),
    ('华莱士访谈队', NOW(), '124640BF2792A0CDCE2C04E13326D67BF013BAC6CE546616B04888E7C4E68631');

-- Password for these six teams are '2333'

INSERT INTO `students` (`studentName`, `studentNo`, `contact`, `campus`, `college`, `major`, `grade`, `teamID`, `teamCharacter`)
	VALUES
    ('江泽民', '201522223333', '15923336666', '大学城校区', '新闻学院', '长跑与赛艇技术', '2013级', 1001, 'teamLeader'),
    ('董建华', '201522223333', '15923336666', '大学城校区', '新闻学院', '长跑与赛艇技术', '2016级', 1001, 'teamMember'),
    ('张宝华', '201522223333', '15923336666', '五山校区', '新闻学院', '长跑与赛艇技术', '2015级', 1001, 'teamMember'),
    ('江泽民', '201522223333', '15923336666', '大学城校区', '气象与气候学院', '天气预报', '2015级', 1002, 'teamLeader'),
    ('徐嘉诰', '201522223333', '15923336666', '五山校区', '国机二院', '气象专家', '2013级', 1002, 'teamMember'),
    ('郭伟华', '201522223333', '15923336666', '大学城校区', '膜法科学与工程学院', '膜法科学与技术', '2016级', 1002, 'teamMember'),
    ('江泽民', '201522223333', '15923336666', '五山校区', '外国语学院', '英语交流与访谈', '2013级', 1003, 'teamLeader'),
    ('华莱士', '201522223333', '15923336666', '大学城校区', '外国语学院', '英语交流与访谈', '2012级', 1003, 'teamMember'),
    ('江泽民', '201522223333', '15923336666', '大学城校区', '新闻学院', '长跑与赛艇技术', '2013级', 2001, 'teamLeader'),
    ('董建华', '201522223333', '15923336666', '大学城校区', '新闻学院', '长跑与赛艇技术', '2016级', 2001, 'teamMember'),
    ('张宝华', '201522223333', '15923336666', '五山校区', '新闻学院', '长跑与赛艇技术', '2015级', 2001, 'teamMember'),
    ('江泽民', '201522223333', '15923336666', '大学城校区', '气象与气候学院', '天气预报', '2015级', 2002, 'teamLeader'),
    ('徐嘉诰', '201522223333', '15923336666', '五山校区', '国机二院', '气象专家', '2013级', 2002, 'teamMember'),
    ('郭伟华', '201522223333', '15923336666', '大学城校区', '膜法科学与工程学院', '膜法科学与技术', '2016级', 2002, 'teamMember'),
    ('江泽民', '201522223333', '15923336666', '五山校区', '外国语学院', '英语交流与访谈', '2013级', 2003, 'teamLeader'),
    ('华莱士', '201522223333', '15923336666', '大学城校区', '外国语学院', '英语交流与访谈', '2012级', 2003, 'teamMember');
    
