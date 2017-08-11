<?php
header('Content-Type: application/json');
require_once('../assets/config.php');

existCheck('teamID', 'password', 'captcha');
blankCheck('teamID', 'studentNo', 'contact', 'newPassword', 'newPasswordConfirm', 'captcha');
if (strtolower($_POST['captcha']) != $_SESSION['captcha']) response(2, '验证码错误！');
if ($_POST['newPassword'] !== $_POST['newPasswordConfirm']) response(3, '两次输入密码不一致！');

$sql = 'SELECT * from `' . ($_POST['teamID'] > 2000 ? 'creativityteams' : 'productionteams') . '` WHERE teamID = ? AND pwdSHA256 = ?';
$stmt = $connect->prepare($sql);
$stmt->execute(array($_POST['teamID'], hash('sha256', $_POST['newPassword'])));
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (empty($result)) response(4, '队伍 ID 或登录密码错误！');

response(0);
