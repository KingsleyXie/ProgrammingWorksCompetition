<?php
header('Content-Type: application/json');
session_start();
require_once('../assets/config.php');

$logedIn = 0;
$dirExist = 0;
if (isset($_SESSION['teamID'])) {
	$logedIn = 1;
	$directory = $fileDir . $_SESSION['teamID'];
}

if ($logedIn && is_dir($directory)) {
	$dirExist = 1;
}

$response = array('logedIn' => $logedIn, 'dirExist' => $dirExist);
echo json_encode($response);
?>