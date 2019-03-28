<?php


// Content of database.php
//CHANGE THE LOGIN CREDENTIALS HERE!!!!!!!!!!
$mysqli = new mysqli('localhost', 'news_user', 'password', 'newssite');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
else{
    
}



?>