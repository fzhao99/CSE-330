<?php
    require "database.php";
    session_start();

    header("Content-Type: application/json");

    $event_num = $_POST['event_num'];
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $event_location = $_POST['event_location'];
    $token = $_POST['token'];
    $session = $_SESSION['token'];

    if(!hash_equals($session, $token)){
        die("CSFR Token fails.");
    }

    // $event_num = 3;
    // $event_name ="testing edit event";
    // $event_date = "CUR_DATE";
    // $start_time =  "CUR_TIME";
    // $end_time ="cur_time";
    // $event_location = "here";



    if(strlen($event_name)>0 && strlen($event_date)>0 && strlen($start_time)>0 && strlen($end_time)>0){
        $user = $_SESSION['username'];

            $stmt1 = $mysqli->prepare("update events set title=?, event_date=?, start_time=?, end_time=?, event_location=? where pk_event_ID=?");
            if($stmt1){
                $event_start = sprintf("%s %s:00", $event_date, $start_time);
                $event_end = sprintf("%s %s:00", $event_date, $end_time);
                $stmt1->bind_param('sssssi', $event_name, $event_date, $event_start, $event_end, $event_location, $event_num);
                $stmt1->execute();
                $stmt1->close();

                echo json_encode(array(
                    'success'=> true,
                    'message'=> "Event successfully edited!"
                ));
            } else {
                echo json_encode(array(
                    'success'=> false,
                    "message"=> "Query Prep 2 Failed"
                ));
            }
            
        // } else {
        //     echo json_encode(array(
        //         'success'=> false,
        //         "message"=> "Query Prep 1 Failed"
        //     ));
        // }
        
    } else {
        echo json_encode(array(
            'success'=> false,
            'message'=> 'Please fill in all fields'
        ));
    }
?>