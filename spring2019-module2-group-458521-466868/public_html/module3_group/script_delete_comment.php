<!DOCTYPE html>
<html lang='en'>

<head>  
    <link rel="stylesheet" type = "text/css" href="main_stylesheet.css"/>
    <title>Edit Stories</title>
</head>
<body>
<?php
require 'database.php';
session_start();
//deletes comment based on ID
$comment_to_delete_ID = $_GET['comment_ID'];

$stmt = $mysqli->prepare("DELETE FROM comments WHERE comment_ID=?");
if($stmt){
    $stmt->bind_param('i', $comment_to_delete_ID);
    $stmt->execute();
    $stmt->close();
    header(sprintf("refresh:3, url=%s",$_SESSION['url_to_return_to']));
    echo('<h1>Success! Redirecting back to the story...</h1>');
}
else{
	printf("Query Prep Failed: %s\n", $mysqli->error);
}


?>

</body>