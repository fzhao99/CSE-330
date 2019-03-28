<?php
require 'database.php';
session_start();
//CHANGE TO SESSION VARIABLE TO MAKE THE SCRIPT WORK

$story_to_edit_ID = $_SESSION['cur_story'];
//save edits into variables to store into the database
$new_title = $_POST['new_title'];
$new_summary = $_POST['new_summary'];
$new_content = $_POST['new_content'];
$new_tag = $_POST['new_tag'];
$new_link = null;

$str_to_check = $_POST['new_link'];
if (strlen($str_to_check) > 0 && strlen(trim($str_to_check)) == 0){
    $new_link = $_POST['new_link'];
}


$stmt = $mysqli->prepare("UPDATE stories SET title=?, summary=?, story_contents=?, story_link=? WHERE story_ID=?");
$stmt2 = $mysqli->prepare("UPDATE stories SET story_tag=? WHERE story_ID=?");

//have statment specifically devoted to updating tags, since the statement may or 
//may not be executed based on if the user wishes to change the tag or not
if($stmt2){
    if($new_tag=="None"){
        $stmt2->close();
    }
    else if($new_tag=="NULL"){
        $stmt2 = $mysqli->prepare("UPDATE stories SET story_tag=NULL WHERE story_ID=?");
        if($stmt2){
            $stmt2->bind_param('i',$story_to_edit_ID);
            $stmt2->execute();
            $stmt2->close();
        }
    }
    else{
        $stmt2->bind_param('si', $new_tag,$story_to_edit_ID);
        $stmt2->execute();
        $stmt2->close();
    }
}

if($stmt){
    $stmt->bind_param('ssssi', $new_title,$new_summary,$new_content,$new_link,$story_to_edit_ID);
    $stmt->execute();
    $stmt->close();

    header('refresh:3; url=logged_in_landingpage.php');
    echo("The edits have been made! Returning you back to landing page...");

}
//redirect submit and then redirect back to profile page



?>