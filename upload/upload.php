<?php
session_start();
require_once('../assets/config.php');

if (!isset($_SESSION['teamID'])) codeReturn(1);
if (empty($_FILES['file']) OR $_FILES['file']['error'] == 4) codeReturn(2);
if ($_FILES['file']['error'] == 1 OR $_FILES['file']['error'] == 2) codeReturn(3);
if ($_FILES['file']['error'] > 0) codeReturn(5);

$filename = iconv('UTF-8', 'GBK', $_FILES['file']['name']);
if (!$filename) codeReturn(4);

$filesize = number_format($_FILES['file']['size'] / 1024 / 1024, 3);

if(!is_dir($fileDir)) mkdir($fileDir);
if(!is_dir($bakDir)) mkdir($bakDir);

$directory = $fileDir . $_SESSION['teamID'];
if (is_dir($directory)) {
    rename($directory, $bakDir . 'Team ' . $_SESSION['teamID'] . date(" @ H.i.s - jS M",time()));
}
mkdir($directory);

if (!move_uploaded_file($_FILES['file']['tmp_name'],$fileDir . $_SESSION['teamID'] . '\\' . $filename)) codeReturn(5);

$response = array('code' => 0, 'filename' => $_FILES['file']['name'], 'filesize' => $filesize);
echo json_encode($response);
