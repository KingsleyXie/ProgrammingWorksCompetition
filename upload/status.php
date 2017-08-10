<?php
session_start();
header('Content-Type: application/json');
require_once('../assets/config.php');

$loggedIn = false; $dirExist = false;
if (isset($_SESSION['teamID'])) {
	$loggedIn = true;
	if (is_dir($fileDir . $_SESSION['teamID']))
		$dirExist = true;
}

$response = array('loggedIn' => $loggedIn, 'dirExist' => $dirExist);
echo json_encode($response);
