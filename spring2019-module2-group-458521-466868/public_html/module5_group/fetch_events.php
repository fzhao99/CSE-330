<?php
session_start();

if(isset($_SESSION['username'])){
    require 'database.php';

    header("Content-Type: application/json");


    $json_str = file_get_contents("php://input");
    $json_obj = json_decode($json_str,true);

    //get post information about date, user
    $username = $_SESSION['username'];
    $date = $json_obj['curDate'];


//grab the requisite events from the database 

    $user_check = $mysqli->prepare("SELECT pk_user_ID FROM users WHERE username =?");
    if($user_check){
        $user_check->bind_param('s', $username);
        $user_check-> execute();
        $user_check->bind_result($pk_user_ID);

        //if the result set of the username is not empty
        if($user_check->fetch()){
            $user_check -> close();

            $stmt = $mysqli->prepare("SELECT event_ID, title,event_date,start_time,end_time,event_location FROM events WHERE user_ID=? AND event_date=?");
            if($stmt){
                //execute query

                $stmt ->bind_param('is', $pk_user_ID,$date);
                $stmt -> execute();
                $stmt -> bind_result($event_id, $fetched_title, $fetched_date, $fetched_start,$fetched_end, $fetched_location);
                //encode into json 
                $events = array();
                while($stmt -> fetch()){
                    $cur_event = array("event_id"=>$event_id, "title"=>$fetched_title, "date" => $fetched_date, "start" =>$fetched_start,"end"=>$fetched_end, "location" => $fetched_location);
                    array_push($events,$cur_event);
                }
                
                echo json_encode(array(
                    "success" => true,
                    "events" => $events
                ));

            }
            else{
                printf("Query Prep Failed: %s\n", $mysqli->error);

                echo json_encode(array(
                    "success" => false,
                    "message" => "Event fetching statement never validated"
                ));
        }
        

        
        }
        else{
            echo json_encode(array(
                "username" => $username,
                "success" => false,
                "uid" => $pk_user_ID,
                "message" => "No matching users"
            ));
        }
    }
    else{
        echo json_encode(array(
            "success" => false,
            "message" => "User check statement never validated"
        ));



    }
}
else{
    echo json_encode(array(
        "success" => false,
        "message" => "user not logged in"
    ));
}




?>