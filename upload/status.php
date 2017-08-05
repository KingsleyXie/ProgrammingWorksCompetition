<?php
header('Content-Type: application/json');
session_start();
require_once('../assets/config.php');

$loggedIn = 0;
$dirExist = 0;
if (isset($_SESSION['teamID'])) {
	$loggedIn = 1;
	$directory = $fileDir . $_SESSION['teamID'];
}

if ($loggedIn && is_dir($directory)) {
	$dirExist = 1;
}

$response = array('loggedIn' => $loggedIn, 'dirExist' => $dirExist);
echo json_encode($response);
?>