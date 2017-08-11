<?php
session_start();
header('Content-Type: application/json');
require_once('../assets/config.php');

existCheck('teamID', 'password', 'captcha');
blankCheck('teamID', 'studentNo', 'contact', 'newPassword', 'newPasswordConfirm', 'captcha');

if (strtolower($_POST['captcha']) != $_SESSION['captcha']) response(2, '验证码错误！');
if ($_POST['newPassword'] !== $_POST['newPasswordConfirm']) response(3, '两次输入密码不一致！');

$sql = '
SELECT * FROM `students`
WHERE `teamID` = ? AND
`studentNo` = ? AND
`contact` = ? AND
`teamCharacter` = \'teamLeader\'';
$stmt = $connect->prepare($sql);
$stmt->execute(array($_POST['teamID'], $_POST['studentNo'], $_POST['contact']));
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (empty($result)) response(4, '验证失败，请确认相关信息填写无误');

$competitionType = $_POST['teamID'] > 2000 ? 'creativityteams' : 'productionteams';
$query = $connect->query('
	SELECT salt
	FROM `' . $competitionType . '`
	WHERE teamID = '. $_POST['teamID'])->fetch(PDO::FETCH_ASSOC);

$sql = '
UPDATE `' . $competitionType . '`
SET `saltedPasswordHash` = ?
WHERE teamID = ' . $_POST['teamID'];
$stmt = $connect->prepare($sql);
$stmt->execute(array(hash('sha256', $_POST['newPassword'] . $query['salt'])));
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (!empty($result)) response(5, '密码更新失败，请重新尝试');

response(0);
