<?php
    
    function increase_likes($story_id, $curr_likes){
        require 'database.php';
        $stmt = $mysqli->prepare("update stories set num_likes = ? where stories.story_ID = ?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        if(!isset($curr_likes)){
            $likes = 1;
        } else {
            $likes = $curr_likes + 1;
        }
        $stmt->bind_param('dd', $likes, $story_id);
        $stmt->execute();
        $stmt->close();
    }
?>