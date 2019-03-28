
<!DOCTYPE html>
<html lang='en'>

<head>  
    <link rel="stylesheet" type = "text/css" href="main_stylesheet.css"/>
    <title>Delete Stories</title>
</head>
<body>
<?php
require 'database.php';
session_start();
$story_to_delete_ID = $_GET['story_ID'];

$stmt = $mysqli->prepare("DELETE FROM comments WHERE story_ID=?");
    if($stmt){
        $stmt->bind_param('i', $story_to_delete_ID);
        $stmt->execute();
        $stmt->close();
    }
else{
	printf("Query Prep Failed: %s\n", $mysqli->error);
}


$stmt2 = $mysqli->prepare("DELETE FROM stories WHERE story_ID=?");
    if($stmt2){
        $stmt2->bind_param('i', $story_to_delete_ID);
        $stmt2->execute();
        $stmt2->close();
        header('refresh:3; url=logged_in_landingpage.php');
        echo("The story has been deleted! Returning you back to landing page...");
    
    }
else{
	printf("Query Prep Failed: %s\n", $mysqli->error);
}


?>

</body>