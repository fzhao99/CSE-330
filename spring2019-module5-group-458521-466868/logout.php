<?php
    ini_set("session.cookie_httponly", 1);
    session_start();
    if(session_status()==2){
        session_destroy();
        echo json_encode(array("success"=>true));
    } else {
        echo json_encode(array("success"=> false, "message" => "Logout failed"));
    }
?>