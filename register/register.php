<?php
session_start();
header('Content-Type: application/json');
require_once('../assets/config.php');

$_POST['teamName'] = str_replace(array(" ", "\t", "\r"), "", $_POST['teamName']);

existCheck('teamName', 'password', 'passwordConfirm', 'competitionType', 'captcha', 'teamLeaderName', 'studentNo', 'contact', 'college', 'major', 'grade', 'campus');
blankCheck('teamName', 'password', 'passwordConfirm', 'competitionType', 'captcha', 'teamLeaderName', 'studentNo', 'contact', 'college', 'major', 'grade', 'campus');
if (strtolower($_POST['captcha']) != $_SESSION['captcha']) codeReturn(1);
if ($_POST['password'] !== $_POST['passwordConfirm']) codeReturn(2);

$competitionType = $_POST['competitionType'] == 2 ? 'creativityteams' : 'productionteams';

$sql = 'SELECT * from `' . $competitionType . '` WHERE teamName = ?';
$stmt = $connect->prepare($sql);
$stmt->execute(array($_POST['teamName']));
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (!empty($result)) codeReturn(3);

$query = $connect->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = \'' . $competitionType . '\'')->fetch(PDO::FETCH_ASSOC);
$nextID = $query['AUTO_INCREMENT'];

$sql = 'INSERT INTO `'. $competitionType .'` (`teamName`, `registerTime`, `pwdSHA256`) VALUES (?,NOW(),?)';
$stmt = $connect->prepare($sql);
$stmt->execute(array($_POST['teamName'], hash('sha256', $_POST['password'])));
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (!empty($result)) codeReturn(5);

$sql = 'INSERT INTO `students` (`studentName`, `studentNo`, `contact`, `campus`, `college`, `major`, `grade`, `teamID`, `teamCharacter`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
$stmt = $connect->prepare($sql);
$stmt->execute(array(
	$_POST['teamLeaderName'],
	$_POST['studentNo'],
	$_POST['contact'],
	$_POST['campus'],
	$_POST['college'],
	$_POST['major'],
	$_POST['grade'],
	$nextID, 'teamLeader'));

for ($i = 1; $i < 5; $i++) {
	if(($_POST['teamMemberName' . $i] !== '') AND 
		($_POST['studentNo' . $i] !== '') AND 
		($_POST['contact' . $i] !== '') AND 
		($_POST['college' . $i] !== '') AND 
		($_POST['major' . $i] !== '') AND 
		($_POST['grade' . $i] !== 0) AND 
		($_POST['campus' . $i] !== 0)) {
		$sql = 'INSERT INTO `students` (`studentName`, `studentNo`, `contact`, `campus`, `college`, `major`, `grade`, `teamID`, `teamCharacter`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$stmt = $connect->prepare($sql);
		$stmt->execute(array(
			$_POST['teamMemberName' . $i],
			$_POST['studentNo' . $i],
			$_POST['contact' . $i],
			$_POST['campus' . $i],
			$_POST['college' . $i],
			$_POST['major' . $i],
			$_POST['grade' . $i],
			$nextID, 'teamMember'));
	}
}

$_SESSION['teamID'] = $nextID;
$_SESSION['teamName'] = $_POST['teamName'];

$response = array(
	'code' => 0,
	'competitionType' => $_POST['competitionType'],
	'teamID' => $_SESSION['teamID'],
	'teamName' => $_SESSION['teamName']);
echo json_encode($response);
