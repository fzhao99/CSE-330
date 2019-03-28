<?php
require 'database.php';
session_start();
//CHANGE TO SESSION VARIABLE TO MAKE THE SCRIPT WORK

$comment_to_edit_ID =$_SESSION['comment_to_edit'];

//save edits into variables to store into the database
$new_comment = $_POST['new_comment'];

$stmt = $mysqli->prepare("UPDATE comments SET user_comment=?, date_posted=CURRENT_TIMESTAMP WHERE comment_ID=?");

if($stmt){
    $stmt->bind_param('si', $new_comment,$comment_to_edit_ID);
    $stmt->execute();
    $stmt->close();
    header(sprintf("refresh:3, url=%s",$_SESSION['url_to_return_to']));
    echo('<h1>Success! Redirecting back to the story...</h1>');
}
//redirect submit and then redirect back to profile page
else{
	printf("Query Prep Failed: %s\n", $mysqli->error);
}

?>