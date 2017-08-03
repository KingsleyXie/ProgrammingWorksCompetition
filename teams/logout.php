<?php
    session_start();
    header('Content-Type: application/json');
    $response = array('code' => 0, 'teamName' => $_SESSION['teamName']);
    unset ($_SESSION['teamID']);
    unset ($_SESSION['teamName']);
    echo json_encode($response);
?>
