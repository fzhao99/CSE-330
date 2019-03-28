<?php
if(isset($_POST['username'])){

    session_start();
    include 'file_script.php';
    //grabbing file name
    $file = $_SESSION['temp_delete_file'];
    $username = $_SESSION['username'];
    $filepath = generate_file_path($file,$username);

    //appending file name to 'deleted_files' array
    $_SESSION['deleted_files'][] = $file;

    //deletes file from directory
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
