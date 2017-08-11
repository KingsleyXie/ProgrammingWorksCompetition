<?php
session_start();
header('Content-Type: application/json');
require_once('../assets/config.php');

$response[0] = array( 'loggedIn' => false);
$index = 1;

if (isset($_SESSION['teamID'])) {
	$response[0] = array( 'loggedIn' => true);
	foreach($connect->query('
		SELECT *
		FROM students
		WHERE teamID = ' . $_SESSION['teamID']) as $student) {
		$response[$index] = array(
			'studentName' => $student['studentName'],
			'studentNo' => $student['studentNo'],
			'contact' => $student['contact'],
			'campus' => $student['campus'],
			'college' => $student['college'],
			'major' => $student['major'],
			'grade' => $student['grade']);
		$index++;
	}
}

foreach($connect->query(
	'SELECT
	productionTeams.teamID AS teamID,
	productionTeams.teamName,
	productionteams.registerTime,
	students.studentID AS studentID,
	students.studentName,
	students.campus,
	students.college,
	students.major,
	students.grade
	FROM productionTeams
	INNER JOIN students
	ON productionTeams.teamID = students.teamID
	UNION ALL
	SELECT
	creativityTeams.teamID AS teamID,
	creativityTeams.teamName,
	creativityteams.registerTime,
	students.studentID AS studentID,
	students.studentName,
	students.campus,
	students.college,
	students.major,
	students.grade
	FROM creativityTeams
	INNER JOIN students
	ON creativityTeams.teamID = students.teamID
	ORDER BY teamID DESC, studentID ASC
	') as $data) {

	if ((!isset($teamID)) OR ($teamID != $data['teamID'])) {
		$teamID = $data['teamID'];
		if (isset($students) AND sizeof($students)) {
			$response[$index]['students'] = $students;
			$index++;
		};
		$students = array(array(
				'studentName' => $data['studentName'],
				'campus' => $data['campus'],
				'college' => $data['college'],
				'major' => $data['major'],
				'grade' => $data['grade']));
		$response[$index] = array(
			'teamName' => $data['teamName'],
			'teamID' => $data['teamID'],
			'calendarTime' => date("Y-m-d",strtotime($data['registerTime'])),
			'clockTime' => date("H:i",strtotime($data['registerTime'])));
	} else {
		array_push($students, array(
			'studentName' => $data['studentName'],
			'campus' => $data['campus'],
			'college' => $data['college'],
			'major' => $data['major'],
			'grade' => $data['grade']));
	}
}
$response[$index]['students'] = $students;
echo json_encode($response);
