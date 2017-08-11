<?php
header('Content-Type: application/json');
require_once('../assets/config.php');

$index = 0;
foreach($connect->query('
	SELECT *
	FROM forum
	ORDER BY ID DESC') as $message) {
	$response[$index] = array(
		'nickname' => htmlspecialchars($message['nickname']),
		'message' => htmlspecialchars($message['message']),
		'calendarTime' => date("Y-m-d",strtotime($message['postTime'])),
		'clockTime' => date("H:i",strtotime($message['postTime']))
	);
	$index++;
}
echo json_encode($response);
