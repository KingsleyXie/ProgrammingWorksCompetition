<?php
/*----------------------------------------------------------------------------------------------
This Shit PHP Code is a fucking useless tool for importing data from Database to Excel
Run or Visit this PHP file, **save as HTML file**, then copy the results and paste into Excel
CAUTIONS: DO NOT PUT THIS FILE IN ONLINE ENVIRONMENT!!! OR YOU WILL LEAK ALL THE DATA
----------------------------------------------------------------------------------------------*/

require_once("./assets/config.php");

echo "作品赛队伍\n";
foreach($connect->query('
	SELECT *
	FROM productionTeams
	ORDER BY teamID DESC') as $team) {
	
	$sql = '
	SELECT *
	FROM students
	WHERE teamID = ?';
	$stmt = $connect->prepare($sql);
	$stmt->execute(array($team['teamID']));
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	echo "队名\t队伍 ID\t注册日期\t注册时间\n";
	echo $team['teamName'] . "\t" . $team['teamID'] . "\t" . date("Y-m-d",strtotime($team['registerTime'])). "\t" . date("H:i",strtotime($team['registerTime'])) . "\n";
	echo "\n";
	echo "姓名\t学号\t联系方式\t校区\t学院\t专业\t年级\n";
	foreach($result as $student) {
		echo $student['studentName'] . "\t" . $student['studentNo'] . "\t" . $student['contact'] . "\t" . $student['campus'] . "\t" . $student['college'] . "\t" . $student['major'] . "\t" . $student['grade'] . "\n";
	}
	echo "\n\n\n";
}

echo "创意赛队伍\n";
foreach($connect->query('
	SELECT *
	FROM creativityteams
	ORDER BY teamID DESC') as $team) {

	$sql = '
	SELECT *
	FROM students
	WHERE teamID = ?';
	$stmt = $connect->prepare($sql);
	$stmt->execute(array($team['teamID']));
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	echo "队名\t队伍 ID\t注册日期\t注册时间\n";
	echo $team['teamName'] . "\t" . $team['teamID'] . "\t" . date("Y-m-d",strtotime($team['registerTime'])). "\t" . date("H:i",strtotime($team['registerTime'])) . "\n";
	echo "\n";
	echo "姓名\t学号\t联系方式\t校区\t学院\t专业\t年级\n";
	foreach($result as $student) {
		echo $student['studentName'] . "\t" . $student['studentNo'] . "\t" . $student['contact'] . "\t" . $student['campus'] . "\t" . $student['college'] . "\t" . $student['major'] . "\t" . $student['grade'] . "\n";
	}
	echo "\n\n\n";
}























foreach($connect->query('SELECT * from creativityteams ORDER BY teamID DESC') as $team) {
	$sql = 'SELECT * from students where teamID = ?';
	$stmt = $connect->prepare($sql);
	$stmt->execute(array($team['teamID']));
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stuIndex = 0;
	foreach($result as $student) {
		$students[$stuIndex] = array('姓名' => $student['studentName'], '学号' => $student['studentNo'], '联系方式' => $student['contact'], '校区' => $student['campus'], '学院' => $student['college'], '专业' => $student['major'], '年级' => $student['grade']);
		$stuIndex++;
	}
	$response[$index] = array('队名' => $team['teamName'], '队伍 ID' => $team['teamID'], '注册日期' => date("Y-m-d",strtotime($team['registerTime'])), '注册时间' => date("H:i",strtotime($team['registerTime'])), 'students' => $students);
	unset($students);
	$index++;
}

?>
