<?php
session_start();
header('Content-Type: application/json');
require_once('../assets/config.php');

existCheck('teamID', 'password', 'captcha');
if (strtolower($_POST['captcha']) != $_SESSION['captcha']) response(1, '验证码错误！');

$sql = 'SELECT * from `' . ($_POST['teamID'] > 2000 ? 'creativityteams' : 'productionteams') . '` WHERE teamID = ? AND pwdSHA256 = ?';
$stmt = $connect->prepare($sql);
$stmt->execute(array($_POST['teamID'], hash('sha256', $_POST['password'])));
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (empty($result)) response(2, '队伍 ID 或登录密码错误！');

$_SESSION['teamID'] = $result[0]['teamID'];
$_SESSION['teamName'] = $result[0]['teamName'];
$response = array('code' => 0, 'teamName' => $_SESSION['teamName']);
echo json_encode($response);
