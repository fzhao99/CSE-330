<?php
    $mysqli = new mysqli('localhost', 'news_user', 'password', 'newssite');
    if($mysqli->connect_errno){
        printf("Connection Failed: %s\n", $mysqli->connect_error);
        exit;
    }
    else {
        
    }
?>