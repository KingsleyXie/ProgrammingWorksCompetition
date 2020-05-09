<?php
session_start();
require_once('../assets/config.php');

if (!isset($_SESSION['teamID'])) response(1, '请<a href=\'../login\'>登录</a>系统后提交文件！');
if (empty($_FILES['file']) OR $_FILES['file']['error'] == 4) response(2, '请选择上传文件！');
if ($_FILES['file']['error'] == 1 OR $_FILES['file']['error'] == 2) response(3, '很抱歉，上传文件过大，请联系管理员');
if ($_FILES['file']['error'] > 0) response(4, '文件发生未知错误，请尝试重新上传');

$filename = iconv('UTF-8', 'GBK', $_FILES['file']['name']);
if (!$filename) response(5, '上传失败，请使用简体中文、英文或数字命名文件');

$filesize = number_format($_FILES['file']['size'] / 1024 / 1024, 3);

if(!is_dir($fileDir)) mkdir($fileDir);
if(!is_dir($bakDir)) mkdir($bakDir);

$directory = $fileDir . $_SESSION['teamID'];
if (is_dir($directory)) {
    rename($directory, $bakDir . 'Team ' . $_SESSION['teamID'] . date(" @ H.i.s - jS M",time()));
}
mkdir($directory);

if (!move_uploaded_file($_FILES['file']['tmp_name'],$fileDir . $_SESSION['teamID'] . '/' . $filename)) response(6, '上传失败，请尝试重新上传');

$response = array('code' => 0, 'filename' => $_FILES['file']['name'], 'filesize' => $filesize);
echo json_encode($response);
