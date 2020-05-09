<?php
/*********************************************************************************************
  * This naive PHP file is a fucking useless tool for exporting data
  * Just visit it and all the data will be automatically downloaded in CSV format
  * CAUTIONS: DO NOT PUT THIS FILE IN ONLINE ENVIRONMENT!!! OR YOU WILL LEAK ALL THE DATA
  *******************************************************************************************/

require_once('./assets/config.php');

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=报名数据（未分隔）.csv');
header('Cache-Control: max-age=0');

echo pack('H*','EFBBBF'); // Add UTF-8 BOM
echo '队伍 ID,队名,姓名,学号,联系方式,校区,学院,专业,年级,注册时间' . "\n";

foreach($connect->query('
	SELECT
		productionTeams.teamID AS teamID,
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
	UNION ALL
	SELECT
		creativityTeams.teamID AS teamID,
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
	ORDER BY teamID ASC', PDO::FETCH_ASSOC
) as $member) echo join($member, ',') . "\n";
