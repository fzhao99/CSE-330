<?php
ini_set("session.cookie_httponly", 1);

require "database.php";

    header("Content-Type: application/json");
    $names = array();

    $stmt = $mysqli->prepare("select username from users");
    if($stmt){
        $stmt->execute();
        $result = $stmt->get_result();
        

        while($name = $result->fetch_assoc()){
            $username = $name["username"];
            array_push($names,$username);
        }
        echo json_encode($names);
        $stmt->close();
    }
    else{
        echo json_encode($names);
    }


?>