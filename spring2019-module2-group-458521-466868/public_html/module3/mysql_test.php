<?php


// Content of database.php

$mysqli = new mysqli('localhost', 'phpuser', 'Love>bread!1', 'php');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
else{
    printf("Success!");
}



?>