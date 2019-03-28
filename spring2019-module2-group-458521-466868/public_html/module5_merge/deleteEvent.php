<?php
    require 'database.php';
    header("Content-Type: application/json");
    // $json_str = file_get_contents("php://input");
    // $json_obj = json_decode($json_str);

    //$event_num = $json_obj['event_num'];
    $event_num = $_POST['event_num'];
    $stmt = $mysqli->prepare("delete from events where pk_event_ID = ?");
    if($stmt){
        $stmt->bind_param('d', $event_num);
        $stmt->execute();
        $stmt->close();
        echo json_encode(array(
            "success"=> true
        ));
    } else {
        echo json_encode(array(
            "success"=> false,
            "message"=> "Query Prep failed"
        ));
    }

?>