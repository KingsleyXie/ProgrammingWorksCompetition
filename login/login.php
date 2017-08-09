<?php
session_start();
header('Content-Type: application/json');

if (!(isset($_POST['teamID']) AND isset($_POST['password']) AND isset($_POST['captcha']))) {
    $response = array('code' => 3);
    echo json_encode($response);
    return;
}

if (strtolower($_POST['captcha']) != $_SESSION['captcha']) {
    $response = array('code' => 1);
    echo json_encode($response);
    return;
}

require_once('../assets/config.php');

$sql = 'SELECT * from `' . ($_POST['teamID'] > 2000 ? 'creativityteams' : 'productionteams') . '` WHERE teamID = ? AND pwdSHA256 = ?';

$stmt = $connect->prepare($sql);
$stmt->execute(array($_POST['teamID'], hash('sha256', $_POST['password'])));
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($result)) {
    $response = array('code' => 2);
    echo json_encode($response);
}
else {
    $_SESSION['teamID'] = $result[0]['teamID'];
    $_SESSION['teamName'] = $result[0]['teamName'];
    $response = array('code' => 0, 'teamName' => $_SESSION['teamName']);
    echo json_encode($response);
}
