<?php
session_start();
header('Content-Type: application/json');
require_once('../assets/config.php');

existCheck('teamID', 'password', 'captcha');
if (strtolower($_POST['captcha']) != $_SESSION['captcha']) response(2, '验证码错误！');

$sql = '
SELECT *
FROM `' . ($_POST['teamID'] > 2000 ? 'creativityteams' : 'productionteams') . '`
WHERE teamID = ?';
$stmt = $connect->prepare($sql);
$stmt->execute(array($_POST['teamID']));
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
if(empty($result) OR
	(hash('sha256', $_POST['password'] . $result[0]['salt']) !== $result[0]['saltedPasswordHash']))
	response(3, '队伍 ID 或登录密码错误！');

$_SESSION['teamID'] = $result[0]['teamID'];
$_SESSION['teamName'] = $result[0]['teamName'];
echo json_encode(array('code' => 0, 'teamName' => $_SESSION['teamName']));
