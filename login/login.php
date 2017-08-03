<?php
    error_reporting(E_ALL & ~E_NOTICE );
    session_start();
    header('Content-Type: application/json');

    if (!(isset($_POST['teamID']) AND isset($_POST['password']) AND isset($_POST['captcha'])))
    {
        $response = array('code' => 3);
        echo json_encode($response);
    }
    elseif (strtolower($_POST['captcha']) != $_SESSION['captcha'])
    {
        $response = array('code' => 1);
        echo json_encode($response);
    }
    else
    {
        require_once('../assets/config.php');

        $sql = "select * from `productionteams` where teamID = ? and pwdSHA256 = ?";
        if ($_POST['teamID'] >= 2000) {
            $sql = "select * from `creativityteams` where teamID = ? and pwdSHA256 = ?";
        }

        $stmt = $connect->prepare($sql);
        $stmt->execute(array($_POST['teamID'], hash('sha256', $_POST['password'])));
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        if (empty($result)) {
            $response = array('code' => 2);
            echo json_encode($response);
        }
        else {
            $_SESSION['teamID'] = $result->teamID;
            $_SESSION['teamName'] = $result->teamName;
            $response = array('code' => 0, 'teamName' => $_SESSION['teamName']);
            echo json_encode($response);
        }
    }
?>
