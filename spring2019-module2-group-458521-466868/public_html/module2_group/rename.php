<!DOCTYPE html>
<html lang='en'>
<head>
    <link rel="stylesheet" type="text/css" href="landingpage_stylesheet.css"/>
    <link href="https://fonts.googleapis.com/css?family=Bree+Serif" rel="stylesheet"/>
    <title> Landing Page </title>
</head>
<body>
<?php

session_start();

if(isset($_SESSION['username'])){
    $file = $_SESSION['temp_rename_file'];
    echo sprintf("<form method = 'POST'>");
    echo sprintf("New name: ");
    echo sprintf("<input type = 'text' name = 'rename'/>");
    echo sprintf("<input type = 'submit' value = 'Submit'/></form>");
    if(isset($_POST['rename'])){
        $new_file_name = $_POST['rename'];
        $file_path = sprintf("/var/www/user_files/%s_files/%s", htmlentities($_SESSION['username']), htmlentities($file));
        $type = pathinfo($file_path, PATHINFO_EXTENSION);
        $path =  sprintf("/var/www/user_files/%s_files/%s.%s", htmlentities($_SESSION['username']), htmlentities($new_file_name), htmlentities($type));
        
        echo($file_path);
        if(rename($file_path, $path)){
            header("Location: user_files.php");
        }
        else {
            echo (htmlentities("failure!"));
        }
    }
}
else{
    header("Location: file_sharing_login.php");
}
    

?>
</body>