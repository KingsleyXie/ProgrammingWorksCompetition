<?php
/*********************************************************************************************
  * This naive PHP file is a fucking useless tool for exporting data
  * Just visit it and all the data will be automatically downloaded in CSV format
  * CAUTIONS: DO NOT PUT THIS FILE IN ONLINE ENVIRONMENT!!! OR YOU WILL LEAK ALL THE DATA
  *******************************************************************************************/

require_once('./assets/config.php');

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=报名数据（按队伍分隔）.csv');
header('Cache-Control: max-age=0');

echo pack('H*','EFBBBF'); // Add UTF-8 BOM

echo 'Part A. 作品赛队伍' . "\n";
foreach($connect->query('
	SELECT DISTINCT teamID
	FROM productionTeams
	ORDER BY teamID ASC
') as $team) {
	echo "\n" . '队伍 ID,队名,姓名,学号,联系方式,校区,学院,专业,年级,注册时间' . "\n";
	foreach($connect->query('
		SELECT
			productionTeams.teamID,
			productionTeams.teamName,
			students.studentName,
			students.studentNo,
			students.contact,
			students.campus,
			students.college,
			students.major,
			students.grade,
			productionTeams.registerTime
		FROM productionTeams
		INNER JOIN students
		ON productionTeams.teamID = students.teamID
		WHERE productionTeams.teamID = ' . $team['teamID'], PDO::FETCH_ASSOC
	) as $member) echo join($member, ',') . "\n";
}

echo "\n\n\n";

echo 'Part B. 创意赛队伍' . "\n";
foreach($connect->query('
	SELECT DISTINCT teamID
	FROM creativityTeams
	ORDER BY teamID ASC
') as $team) {
	echo "\n" . '队伍 ID,队名,姓名,学号,联系方式,校区,学院,专业,年级,注册时间' . "\n";
	foreach($connect->query('
		SELECT
			creativityTeams.teamID,
			creativityTeams.teamName,
			students.studentName,
			students.studentNo,
			students.contact,
			students.campus,
			students.college,
			students.major,
			students.grade,
			creativityTeams.registerTime
		FROM creativityTeams
		INNER JOIN students
		ON creativityTeams.teamID = students.teamID
		WHERE creativityTeams.teamID = ' . $team['teamID'], PDO::FETCH_ASSOC
	) as $member) echo join($member, ',') . "\n";
}
