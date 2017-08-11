<?php
session_start();
header('Content-Type: application/json');
require_once('../assets/config.php');

if (strtolower($_POST['captcha']) != $_SESSION['captcha']) response(1, '验证码错误！');
if (strlen($_POST['nickname']) > 36) response(2, '昵称太长啦~ 精简一下吧');
if (strpos($_POST['nickname'], '管理员') > -1) response(3, "你们呐，不要老喜欢搞个大新闻，就说自己是管理员<br><br>再不改昵称，将来留言板上出了偏差你们是要负责任的");

$sql = '
INSERT INTO `forum`
(`nickname`, `message`)
VALUES
(?,?)';
$stmt = $connect->prepare($sql);
$stmt->execute(array($_POST['nickname'], $_POST['message']));
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (!empty($result)) response(4, '留言失败，请尝试重新提交');

response(0);
