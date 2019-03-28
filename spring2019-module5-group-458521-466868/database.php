<?php


// Content of database.php

$mysqli = new mysqli('localhost', 'calendar_user', 'password', 'calendar');
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
else{
}


?>