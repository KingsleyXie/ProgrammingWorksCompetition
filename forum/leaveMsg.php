<?php
session_start();
header('Content-Type: application/json');
require_once('../assets/config.php');

if (strtolower($_POST['captcha']) != $_SESSION['captcha']) codeReturn(1);
if (strlen($_POST['nickname']) > 36) codeReturn(2);
if (strpos($_POST['nickname'], '管理员') > -1) codeReturn(3);

$sql = 'INSERT INTO `forum` (`nickname`, `message`, `postTime`) VALUES (?,?,NOW())';
$stmt = $connect->prepare($sql);
$stmt->execute(array($_POST['nickname'], $_POST['message']));
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (!empty($result)) codeReturn(4);

codeReturn(0);
