<?php
session_start();
header('Content-Type: application/json');

$_POST['teamName'] = str_replace(array(" ", "\t", "\r"), "", $_POST['teamName']);

if (!(isset($_POST['teamName']) AND isset($_POST['password']) AND isset($_POST['passwordConfirm']) AND isset($_POST['competitionType']) AND isset($_POST['captcha']) AND isset($_POST['teamLeaderName']) AND isset($_POST['studentNo']) AND isset($_POST['contact']) AND isset($_POST['college']) AND isset($_POST['major']) AND isset($_POST['grade']) AND isset($_POST['campus']))) {
	$response = array('code' => 4);
	echo json_encode($response);
	return;
}

if (strtolower($_POST['captcha']) !== $_SESSION['captcha']) {
	$response = array('code' => 1);
	echo json_encode($response);
	return;
}

if ($_POST['password'] !== $_POST['passwordConfirm']) {
	$response = array('code' => 2);
	echo json_encode($response);
	return;
}

require_once('../assets/config.php');

$sql = "SELECT * FROM  `productionteams` WHERE teamName = ? ";
if ($_POST['competitionType'] == 2) {
	$sql = "SELECT * FROM  `creativityteams` WHERE teamName = ? ";
}
$stmt = $connect->prepare($sql);
$stmt->execute(array($_POST['teamName']));
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (!empty($result)) {
	$response = array('code' => 3);
	echo json_encode($response);
	return;
}
$sql = "SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME   = 'productionteams'";
if ($_POST['competitionType'] == 2) {
	$sql = "SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME   = 'creativityteams'";
}
$stmt = $connect->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$nextID = $result[0]['AUTO_INCREMENT'];

$sql = "INSERT INTO `productionteams` (`teamName`, `registerTime`, `pwdSHA256`) VALUES (?,NOW(),?)";
if ($_POST['competitionType'] == 2) {
	$sql = "INSERT INTO `creativityteams` (`teamName`, `registerTime`, `pwdSHA256`) VALUES (?,NOW(),?)";
}
$stmt = $connect->prepare($sql);
$stmt->execute(array($_POST['teamName'], hash('sha256', $_POST['password'])));
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result)) {
	$response = array('code' => 5);
	echo json_encode($response);
	return;
}

$sql = "INSERT INTO `students` (`studentName`, `studentNo`, `contact`, `campus`, `college`, `major`, `grade`, `teamID`, `teamCharacter`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $connect->prepare($sql);
$stmt->execute(array($_POST['teamLeaderName'], $_POST['studentNo'], $_POST['contact'], $_POST['campus'], $_POST['college'], $_POST['major'], $_POST['grade'], $nextID, 'teamLeader'));
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

for ($i=1; $i < 5; $i++) {
	if(($_POST['teamMemberName' . $i] !== '') AND ($_POST['studentNo' . $i] !== '') AND ($_POST['contact' . $i] !== '') AND ($_POST['college' . $i] !== '') AND ($_POST['major' . $i] !== '') AND ($_POST['grade' . $i] !== 0) AND ($_POST['campus' . $i] !== 0)) {
		$sql = "INSERT INTO `students` (`studentName`, `studentNo`, `contact`, `campus`, `college`, `major`, `grade`, `teamID`, `teamCharacter`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $connect->prepare($sql);
		$stmt->execute(array($_POST['teamMemberName' . $i], $_POST['studentNo' . $i], $_POST['contact' . $i], $_POST['campus' . $i], $_POST['college' . $i], $_POST['major' . $i], $_POST['grade' . $i], $nextID, 'teamMember'));
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}

$_SESSION['teamID'] = $nextID;
$_SESSION['teamName'] = $_POST['teamName'];
$response = array('code' => 0, 'competitionType' => $_POST['competitionType'], 'teamID' => $_SESSION['teamID'], 'teamName' => $_SESSION['teamName']);
echo json_encode($response);
?>
