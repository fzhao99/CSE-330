<?php
    require "database.php";
    ini_set("session.cookie_httponly", 1);
    session_start();

    header("Content-Type: application/json");

    $json_str = file_get_contents("php://input");
    $json_obj = json_decode($json_str, true);

    $event_name = $json_obj['event_name'];
    $event_date = $json_obj['event_date'];
    $start_time = $json_obj['start_time'];
    $end_time = $json_obj['end_time'];
    $event_location = $json_obj['event_location'];
    $other_users = $json_obj['usersToShare'];
    $tags = $json_obj['event_tag'];
    $token = $json_obj['token'];
    
   
    // $event_name = "TESTING";
    // $event_date = "CUR_DATE";
    // $start_time =  "CUR_TIME";
    // $end_time ="cur_time";
    // $event_location = "here";
    // $other_users = "bob.zhao";
    // $tags = "School";
    $session = $_SESSION['token'];

    if(!hash_equals($session, $token)){
        echo json_encode(array(
            "success" =>false,
            "message" => "csrf failed"
        ));
        die("CSFR Token fails.");

    }

    if(strlen($event_name)>0 && strlen($event_date)>0 && strlen($start_time)>0 && strlen($end_time)>0){
        $user = $_SESSION['username'];
        $stmt = $mysqli->prepare("select pk_user_ID from users where users.username = ?");
        if($stmt){
       
            $stmt->bind_param('s', $user);
            $stmt->execute();
            $stmt->bind_result($user_id);
            while($stmt->fetch()){
                $id = $user_id;
            }
            $stmt->close();
           
            $stmt1 = $mysqli->prepare("insert into events (title, event_date, start_time, end_time, event_location, tags) values ( ?, ?, ?, ?, ?, ?)");
            if($stmt1){
            
                $event_start = sprintf("%s %s:00", $event_date, $start_time);
                $event_end = sprintf("%s %s:00", $event_date, $end_time);
                $stmt1->bind_param('ssssss', $event_name, $event_date, $event_start, $event_end, $event_location,$tags);
                $stmt1->execute();
                $stmt1->close();

                $stmt2 = $mysqli-> prepare("select max(pk_event_id) from events");
                if($stmt2){
                    $stmt2 -> execute();
                    $result = $stmt2->get_result();
                    $event_ID = $result ->fetch_assoc();
                    $stmt2 ->close();
                    $shared_user_ID = -1;

                    if($other_users!="" && $other_users!= "None"){
                        $stmt4 = $mysqli -> prepare("select pk_user_id from users where username = ?");
                        if($stmt4){
                            $stmt4 ->bind_param('s',$other_users);
                            $stmt4 -> execute();
                            $result = $stmt4->get_result();
                            $output = $result ->fetch_assoc();
                            $shared_user_ID = $output['pk_user_id'];
                            $stmt4 ->close();
                        }
                    }
                    $stmt3 = $mysqli -> prepare("insert into users2events (user_ID,event_ID) values (?,?)");
                  
                    
                    if($stmt3){
                        $new_event = $event_ID['max(pk_event_id)'];
                        $stmt3->bind_param('ii',$user_id,$new_event);
                        $stmt3 -> execute();
                        $stmt3 -> close();
                        if($shared_user_ID != -1){
                            $stmt4 = $mysqli -> prepare("insert into users2events (user_ID,event_ID) values (?,?)");
                            if($stmt4){
                                $stmt4->bind_param('ii',$shared_user_ID,$new_event);
                                $stmt4 -> execute();
                                $stmt4 -> close();
                                echo json_encode(array(
                                    'success'=> true,
                                    'event_ID' => $event_ID,
                                    'shared_ID' => $shared_user_ID,
                                    'message'=> "Shared event successfully added!"
                                ));
                        }
                        else{
                        echo json_encode(array(
                            'success'=> true,
                            'message'=> "Event successfully added!"
                        ));
                    }
                    }
                    else{
                        echo json_encode(array(
                            'success'=> true,
                            'message'=> "Event successfully added!"
                        ));
                    }
                }
                    else{
                        echo json_encode(array(
                            'success'=> false,
                            "message"=> "event_id never selected"
                        ));
                }
           
                }
               
            } else {
                echo json_encode(array(
                    'success'=> false,
                    "message"=> "Query Prep 2 Failed"
                ));
            }
            
        } else {
            echo json_encode(array(
                'success'=> false,
                "message"=> "Query Prep 1 Failed"
            ));
        }
        
    } else {
        echo json_encode(array(
            'success'=> false,
            'message'=> 'Please fill in all fields'
        ));
    }

?>