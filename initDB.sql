-- DROP DATABASE IF EXISTS competition;
CREATE DATABASE competition DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE competition;

CREATE TABLE `productionTeams`(
  `teamID` INTEGER NOT NULL AUTO_INCREMENT,
  `teamName` VARCHAR(90) NOT NULL,
  `registerTime` TIMESTAMP NOT NULL,
  `salt` VARCHAR(90) NOT NULL,
  `saltedPasswordHash` VARCHAR(90) NOT NULL,
  PRIMARY KEY(`teamID`),
  UNIQUE KEY `teamName_UNIQUE`(`teamName`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 AUTO_INCREMENT=1001;

CREATE TABLE `creativityTeams`(
  `teamID` INTEGER NOT NULL AUTO_INCREMENT,
  `teamName` VARCHAR(90) NOT NULL,
  `registerTime` TIMESTAMP NOT NULL,
  `salt` VARCHAR(90) NOT NULL,
  `saltedPasswordHash` VARCHAR(90) NOT NULL,
  PRIMARY KEY(`teamID`),
  UNIQUE KEY `teamName_UNIQUE`(`teamName`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 AUTO_INCREMENT=2001;

CREATE TABLE `students`(
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
  PRIMARY KEY(`studentID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE `forum`(
  `ID` INTEGER NOT NULL AUTO_INCREMENT,
  `nickname` VARCHAR(30) NOT NULL,
  `message` VARCHAR(200) NOT NULL,
  `postTime` TIMESTAMP NOT NULL,
  PRIMARY KEY(`ID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

-- This is the first and default message to be showed in forum:
-- Note: You should run a SQL statement like this if you want to post a message as administrator
INSERT INTO `forum` (`nickname`, `message`, `postTime`)
  VALUES
    ('管理员', '大家好~ 讨论留言功能已经上线啦，欢迎大家热情参与哦', NOW());





/*
-- The following data are made for test while developing the system
INSERT INTO `productionTeams` (`teamName`, `registerTime`, `salt`, `saltedPasswordHash`)
  VALUES
    ('怒斥香港记者队', NOW(), 'fd052f4aec3de2e22fb8c40fc707dc766dcac39a', 'a728d2a03745a8cd9a3bbd0fe6246c6cdec8691fe063ee996139c05dbd5aace8'),
    ('视察二院队', NOW(), '4ad8332887bac2754e7338ee8b60fd2b80f78643', 'd78483e3d4402bcb4aa2c664b8bd3163bea14203501d28c3b53cfc2802d09d9c'),
    ('华莱士访谈队', NOW(), 'a0a1f3839e9ec1941429b6d4eb2c79316eb22d0f', '578991d2b39972a39ab2c50d3ab5fca1af1ae98b38a7d7a1385543c66b351d65');

INSERT INTO `creativityTeams` (`teamName`, `registerTime`, `salt`, `saltedPasswordHash`)
  VALUES
    ('怒斥香港记者队', NOW(), '285c2b590d18a028dfbfc5406bce77cf06e9fe87', '81d256538f18586ad558fdd3c244e4142662ba280ead0d0c738ec5a5b8b653eb'),
    ('视察二院队', NOW(), '3e6296c693ea16112b5d63f2bad30463d3f79be3', 'defe58d3f9c873406df50613643bd4313495db9fc6b3a6eaedb4bc14037e6636'),
    ('华莱士访谈队', NOW(), '94f2e0b113edf074ed8cc907ef4bdc1c9dc895f2', '253cf5cbcda1cbc856f1b056208db174f31feef9c26218423572affbdfaa7c47');

-- Note: Passwords for these six teams are all '2333'



INSERT INTO `students` (`studentName`, `studentNo`, `contact`, `campus`, `college`, `major`, `grade`, `teamID`, `teamCharacter`)
	VALUES
    ('Elder', '201522223333', '15923336666', '大学城校区', '新闻学院', '长跑与赛艇技术', '2013级', 1001, 'teamLeader'),
    ('董建华', '201522223333', '15923336666', '大学城校区', '新闻学院', '长跑与赛艇技术', '2016级', 1001, 'teamMember'),
    ('张宝华', '201522223333', '15923336666', '五山校区', '新闻学院', '长跑与赛艇技术', '2015级', 1001, 'teamMember'),
    ('Elder', '201522223333', '15923336666', '大学城校区', '气象与气候学院', '天气预报', '2015级', 1002, 'teamLeader'),
    ('徐嘉诰', '201522223333', '15923336666', '五山校区', '国机二院', '气象专家', '2013级', 1002, 'teamMember'),
    ('郭伟华', '201522223333', '15923336666', '大学城校区', '膜法科学与工程学院', '膜法科学与技术', '2016级', 1002, 'teamMember'),
    ('Elder', '201522223333', '15923336666', '五山校区', '外国语学院', '英语交流与访谈', '2013级', 1003, 'teamLeader'),
    ('华莱士', '201522223333', '15923336666', '大学城校区', '外国语学院', '英语交流与访谈', '2012级', 1003, 'teamMember'),
    ('Elder', '201522223333', '15923336666', '大学城校区', '新闻学院', '长跑与赛艇技术', '2013级', 2001, 'teamLeader'),
    ('董建华', '201522223333', '15923336666', '大学城校区', '新闻学院', '长跑与赛艇技术', '2016级', 2001, 'teamMember'),
    ('张宝华', '201522223333', '15923336666', '五山校区', '新闻学院', '长跑与赛艇技术', '2015级', 2001, 'teamMember'),
    ('Elder', '201522223333', '15923336666', '大学城校区', '气象与气候学院', '天气预报', '2015级', 2002, 'teamLeader'),
    ('徐嘉诰', '201522223333', '15923336666', '五山校区', '国机二院', '气象专家', '2013级', 2002, 'teamMember'),
    ('郭伟华', '201522223333', '15923336666', '大学城校区', '膜法科学与工程学院', '膜法科学与技术', '2016级', 2002, 'teamMember'),
    ('Elder', '201522223333', '15923336666', '五山校区', '外国语学院', '英语交流与访谈', '2013级', 2003, 'teamLeader'),
    ('华莱士', '201522223333', '15923336666', '大学城校区', '外国语学院', '英语交流与访谈', '2012级', 2003, 'teamMember');

-- Show All teams' information
SELECT productionTeams.*, students.*
FROM productionTeams INNER JOIN students
ON productionTeams.teamID = students.teamID
UNION ALL
SELECT creativityTeams.*, students.*
FROM creativityTeams INNER JOIN students
ON creativityTeams.teamID = students.teamID;
*/
