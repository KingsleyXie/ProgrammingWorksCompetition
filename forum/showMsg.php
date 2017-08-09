<?php
header('Content-Type: application/json');

require_once('../assets/config.php');

$sql = 'SELECT * from forum ORDER BY ID DESC';

$stmt = $connect->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$index = 0;
foreach($result as $message) {
	$response[$index] = array(
		'nickname' => htmlspecialchars($message['nickname']),
		'message' => htmlspecialchars($message['message']),
		'calendarTime' => date("Y-m-d",strtotime($message['postTime'])),
		'clockTime' => date("H:i",strtotime($message['postTime']))
	);
	$index++;
}
echo json_encode($response);
