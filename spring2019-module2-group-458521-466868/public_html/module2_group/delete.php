<?php

session_start();

if(isset($_SESSION['username'])){

include 'file_script.php';
$file = $_SESSION['temp_delete_file'];
$username = $_SESSION['username'];

$filepath = generate_file_path($file,$username);
$_SESSION['deleted_files'][] = $file;

if(unlink($filepath)){
    header("Location: user_files.php");
}
else{
    echo("failure!");
}
}
else{
    header("Location: file_sharing_login.php");
}

?>
