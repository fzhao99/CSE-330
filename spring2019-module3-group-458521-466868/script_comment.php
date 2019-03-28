<?php

    function add_comment($comment, $story_num){
        require 'database.php';
        $user_id = $_SESSION['user_id'];
        
        $stmt = $mysqli->prepare("insert into comments (story_ID, user, date_posted, user_comment) values (?, ?, CURRENT_TIMESTAMP, ?)");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
	        exit;
        }
        $stmt->bind_param('dds', $story_num, $user_id, $comment);
        $stmt->execute();
        $stmt->close();
    }
   

?>