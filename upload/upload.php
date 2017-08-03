<?php
error_reporting(0);
session_start();

if (!isset($_SESSION['teamID'])) {
    $response = array('code' => 1);
    echo json_encode($response);
    return;
}

if (empty($_FILES['file']) OR $_FILES['file']['error'] == 4) {
    $response = array('code' => 2);
    echo json_encode($response);
    return;
}

if ($_FILES['file']['error'] == 1 OR $_FILES['file']['error'] == 2) {
    $response = array('code' => 3);
    echo json_encode($response);
    return;
}

if ($_FILES['file']['error'] > 0) {
    $response = array('code' => 5);
    echo json_encode($response);
    return;
}

$filename = iconv('UTF-8', 'GBK', $_FILES['file']['name']);
$filesize = number_format($_FILES['file']['size'] / 1024 / 1024, 3);

require_once('../assets/config.php');

if(!is_dir($fileDir)) {
	mkdir($fileDir);
}
if(!is_dir($bakDir)) {
	mkdir($bakDir);
}



if (!$filename) {
    $response = array('code' => 4);
    echo json_encode($response);
    return;
}
else {
    $directory = $fileDir . $_SESSION['teamID'];
    if (is_dir($directory)) {
        rename($directory, $bakDir . 'Team ' . $_SESSION['teamID'] . date(" @ H.i.s - jS M",time()));
    }
    mkdir($directory);
    if (move_uploaded_file($_FILES['file']['tmp_name'],$fileDir . $_SESSION['teamID'] . '\\' . $filename)) {
        $response = array('code' => 0, 'filename' => $_FILES['file']['name'], 'filesize' => $filesize);
    }
    else {
        $response = array('code' => 5);
    }
    echo json_encode($response);
}
?>
