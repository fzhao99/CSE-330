<?php
if(isset($_POST['username'])){
    session_start();
    //renames file 
    $file = $_SESSION['temp_rename_file'];
    echo sprintf("<form method = 'POST'>");
    echo sprintf("New name: ");
    echo sprintf("<input type = 'text' name = 'rename'/>");
    echo sprintf("<input type = 'submit' value = 'Submit'/></form>");
    if(isset($_POST['rename'])){
        $new_file_name = $_POST['rename'];
        $file_path = sprintf("/var/www/user_files/%s_files/%s", htmlentities($_SESSION['username']), htmlentities($file));
        //gets file extension to append to end of new file name
        $type = pathinfo($file_path, PATHINFO_EXTENSION);
        $path =  sprintf("/var/www/user_files/%s_files/%s.%s", htmlentities($_SESSION['username']), htmlentities($new_file_name), htmlentities($type));
        echo($file_path);
        //redirects to user file page
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