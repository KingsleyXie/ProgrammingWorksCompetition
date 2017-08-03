<?php
header('Content-Type: application/json');

require_once('../assets/config.php');

$sql = 'SELECT * from forum ORDER BY ID DESC';
$stmt = $connect->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$index = 0;

foreach($result as $messages) {
	$response[$index] = array('nickname' => htmlspecialchars($messages['nickname']), 'message' => htmlspecialchars($messages['message']), 'calendarTime' => date("Y-m-d",strtotime($messages['postTime'])), 'clockTime' => date("H:i",strtotime($messages['postTime'])));
	$index++;
}
echo json_encode($response);
?>
