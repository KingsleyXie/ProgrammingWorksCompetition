<?php
session_start();
header('Content-Type: application/json');

if (strtolower($_POST['captcha']) != $_SESSION['captcha']) {
    $response = array('code' => 1);
    echo json_encode($response);
    return;
}

if (strlen($_POST['nickname']) > 36) {
    $response = array('code' => 2);
    echo json_encode($response);
    return;
}

if (strpos($_POST['nickname'], '管理员') > -1) {
    $response = array('code' => 3);
    echo json_encode($response);
    return;
}

require_once('../assets/config.php');

$sql = 'INSERT INTO `forum` (`nickname`, `message`, `postTime`) VALUES (?,?,NOW())';

$stmt = $connect->prepare($sql);
$stmt->execute(array($_POST['nickname'], $_POST['message']));
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($result)) {
    $response = array('code' => 0);
}
else {
    $response = array('code' => 4);
}
echo json_encode($response);
