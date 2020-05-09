<?php

//Database Configurations:
$addr = 'localhost';			//Database Address
$dbname = 'competition';		//Database Name
$user = 'competition_DB_username_here';					//Username for Project Database
$password = 'corresponding_password_here';		//Password for Project Database

//Database Connection based on PDO:
try {
	$connect = new PDO("mysql:host=$addr;dbname=$dbname;charset=utf8", $user, $password);
} catch(PDOException $ex) {
    response(233, '数据库连接出错，请联系管理员');
    exit(0);
}



//Return Code Process Function:
function response($code, $errMsg='success') {
	echo json_encode(array('code' => $code, 'errMsg' => $errMsg));
	exit(0);
}

//Check whether required paraments exist or not
function existCheck() {
	for($i = 0; $i < func_num_args(); $i++) {
		if (!isset($_POST[func_get_arg($i)])) {
			header('Location: http://p1.img.cctvpic.com/20120409/images/1333902721891_1333902721891_r.jpg');
			exit(0);
		}
	}
}

//Check if necessary paraments are blank
function blankCheck() {
	for($i = 0; $i < func_num_args(); $i++) {
		if (($_POST[func_get_arg($i)] == '') OR ($_POST[func_get_arg($i)] === 0)) {
			response(1, '必填项中含有空值');
			exit(0);
		}
	}
}



//$competitionType for register, login & reset:
if (isset($_POST['teamID']))
	$competitionType = $_POST['teamID'] > 2000 ? 'creativityTeams' : 'productionTeams';
if (isset($_POST['competitionType']))
	$competitionType = $_POST['competitionType'] == 2 ? 'creativityTeams' : 'productionTeams';





/*
 * The Following Directory Paths is just an example in Windows Server, which is exactly the server environment this system was first deployed.
 * Anyway, you can change them to whatever paths you like while making sure the path is writable, and it is better not a path that can access and download directly from your server(web root directory, for example)
 */

//Directory Configurations For Upload Submodule:
date_default_timezone_set('Asia/Shanghai');					//Set Timezone
$fileDir = 'C:\Users\your_user_name\Desktop\Competition\\';		//Upload File Directory
$bakDir = 'C:\Users\your_user_name\Desktop\CompetitionBAK\\';	//Backup File Directory

// Updates For Uinx Platform(WSL Here For Example):
$fileDir = '/mnt/c/Users/your_user_name/Desktop/Competition/';		//Upload File Directory
$bakDir = '/mnt/c/Users/your_user_name/Desktop/CompetitionBAK/';	//Backup File Directory
