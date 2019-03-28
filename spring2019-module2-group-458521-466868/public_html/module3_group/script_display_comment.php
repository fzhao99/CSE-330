<!DOCTYPE html>
<html lang='en'>

<head>  
    <link rel="stylesheet" type = "text/css" href="main_stylesheet.css"/>
    <title>Edit Comment</title>
</head>
<body>
<?php
require 'database.php';
session_start();

//grab the requiste story contents from the database

$comment_to_edit_ID = $_GET['comment_ID'] ;
$_SESSION['comment_to_edit'] = $comment_to_edit_ID;
$stmt = $mysqli->prepare("SELECT user_comment FROM `comments` WHERE comment_ID=?");

if($stmt){
    $stmt->bind_param('i', $comment_to_edit_ID);
    $stmt->execute();
    $stmt->bind_result($comment);
    //display story title, summary, contents in appropriate input fields for editing

while($stmt->fetch()){
    echo('<form action="script_edit_comment.php" method = "POST">');
    
    echo('<label for = "title">Comment: </label> <br>');
    echo(sprintf('<textarea name = "new_comment" class = "edit" id = "comment">%s</textarea>
    <br>',$comment));
    
    echo('<input type = "submit" value = "Save"/>
    </form>');
    }
    
    $stmt->close();
}
else{
	printf("Query Prep Failed: %s\n", $mysqli->error);
}

?>
</body>