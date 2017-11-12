<?php
/*********************************************************************************************
  * This naive PHP file is a fucking useless tool for exporting data
  * Just visit it and all the data will be automatically downloaded in CSV format
  * CAUTIONS: DO NOT PUT THIS FILE IN ONLINE ENVIRONMENT!!! OR YOU WILL LEAK ALL THE DATA
  *******************************************************************************************/

require_once('./assets/config.php');

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=报名数据.csv');
header('Cache-Control: max-age=0');

echo pack('H*','EFBBBF'); // Add UTF-8 BOM

echo 'Part A. 作品赛队伍' . "\n\n";
foreach($connect->query('
		SELECT *
		FROM productionTeams
		ORDER BY teamID DESC
	') as $team) {

	$stmt = $connect->prepare('
		SELECT
			studentName,
			studentNo,
			contact,
			campus,
			college,
			major,
			grade
		FROM students
		WHERE teamID = ?
	');
	$stmt->execute([$team['teamID']]);
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	echo "\n" . '队名,队伍 ID,注册日期,注册时间' . "\n";
	echo $team['teamName'] . ',' . $team['teamID'] . ',' .
		date('Y-m-d',strtotime($team['registerTime'])). ',' .
		date('H:i',strtotime($team['registerTime'])) . "\n";

	echo '队员信息：' . "\n";
	echo '姓名,学号,联系方式,校区,学院,专业,年级' . "\n";
	foreach($result as $student) echo join($student, ',') . "\n";
}

echo "\n\n\n";

echo 'Part B. 创意赛队伍' . "\n\n";
foreach($connect->query('
		SELECT *
		FROM creativityteams
		ORDER BY teamID DESC
	') as $team) {

	$stmt = $connect->prepare('
		SELECT
			studentName,
			studentNo,
			contact,
			campus,
			college,
			major,
			grade
		FROM students
		WHERE teamID = ?
	');
	$stmt->execute([$team['teamID']]);
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	echo "\n" . '队名,队伍 ID,注册日期,注册时间' . "\n";
	echo $team['teamName'] . ',' .
		$team['teamID'] . ',' .
		date('Y-m-d',strtotime($team['registerTime'])). ',' .
		date('H:i',strtotime($team['registerTime'])) . "\n";

	echo '队员信息：' . "\n";
	echo '姓名,学号,联系方式,校区,学院,专业,年级' . "\n";
	foreach($result as $student) echo join($student, ',') . "\n";
}
