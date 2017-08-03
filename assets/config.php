<?php

//Database Configurations:

$addr = 'localhost';			//Database Address
$dbname = 'competition';		//Database Name
$user = 'competition_DB_username_here';					//Username for Project Database
$password = 'corresponding_password_here';		//Password for Project Database

//Database Connection based on PDO
$connect = new PDO("mysql:host=$addr;dbname=$dbname;charset=utf8", $user, $password);



//Directory Configurations For Upload Submodule:

date_default_timezone_set('Asia/Shanghai');					//Set Timezone
$fileDir = 'C:\Users\your_user_name\Desktop\Competition\\';		//Upload File Directory
$bakDir = 'C:\Users\your_user_name\Desktop\CompetitionBAK\\';	//Backup File Directory
/*----------------------------------------------------------------------------------------------
The Above Directory Paths is just an example in Windows Server, which is exactly the server environment this system was first deployed.
Anyway, you can change them to whatever paths you like while making sure the path is writable, and it is better not a path that can access and download directly from your server(web root directory, for example)
----------------------------------------------------------------------------------------------*/
