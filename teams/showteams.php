<?php
session_start();
header('Content-Type: application/json');

require_once('../assets/config.php');

$response[0] = array( 'loggedIn' => 1);
$index = 1;

if (isset($_SESSION['teamID'])) {
    $response[0] = array( 'loggedIn' => 0);
    
    foreach($connect->query('SELECT * from students where teamID = ' . $_SESSION['teamID']) as $student) {
        $response[$index] = array(
        	'studentName' => $student['studentName'],
        	'studentNo' => $student['studentNo'],
        	'contact' => $student['contact'],
        	'campus' => $student['campus'],
        	'college' => $student['college'],
        	'major' => $student['major'],
        	'grade' => $student['grade']);
        $index++;
    }
}

foreach($connect->query('SELECT * from productionTeams ORDER BY teamID DESC') as $team) {
    $stuIndex = 0;
    foreach($connect->query('SELECT * from students where teamID = ' . $team['teamID']) as $student) {
      $students[$stuIndex] = array(
      	'studentName' => $student['studentName'],
      	'campus' => $student['campus'],
      	'college' => $student['college'],
      	'major' => $student['major'],
      	'grade' => $student['grade']);
      $stuIndex++;
    }

    $response[$index] = array(
    	'teamName' => $team['teamName'],
    	'teamID' => $team['teamID'],
    	'calendarTime' => date("Y-m-d",strtotime($team['registerTime'])),
    	'clockTime' => date("H:i",strtotime($team['registerTime'])),
    	'students' => $students);
    unset($students);
    $index++;
}

foreach($connect->query('SELECT * from creativityteams ORDER BY teamID DESC') as $team) {
    $stuIndex = 0;
    foreach($connect->query('SELECT * from students where teamID = ' . $team['teamID']) as $student) {
      $students[$stuIndex] = array(
      	'studentName' => $student['studentName'],
      	'campus' => $student['campus'],
      	'college' => $student['college'],
      	'major' => $student['major'],
      	'grade' => $student['grade']);
      $stuIndex++;
    }
    $response[$index] = array(
    	'teamName' => $team['teamName'],
    	'teamID' => $team['teamID'],
    	'calendarTime' => date("Y-m-d",strtotime($team['registerTime'])),
    	'clockTime' => date("H:i",strtotime($team['registerTime'])),
    	'students' => $students);
    unset($students);
    $index++;
}

echo json_encode($response);
