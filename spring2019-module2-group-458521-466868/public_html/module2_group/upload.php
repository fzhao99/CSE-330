<?php

session_start();

if(isset($_SESSION['username'])){

        include 'file_script.php';

        if(!isset($_FILES['file_upload']) || $_FILES['file_upload']['error'] == UPLOAD_ERR_NO_FILE) {
                echo htmlentities("Error no file selected"); 
        } else {
                print_r("%s",htmlentities(($_FILES)));
        }

        $filename = basename($_FILES['uploadedfile']['name']);
        $username = $_SESSION['username'];
        $date = date('Y-m-d H:i:s');


        //  function from file_script.php
        $full_path = generate_file_path($filename, $username);

        if($full_path == "Invalid filename"){
                header("Location: filename_invalid.html");
        }
        elseif($full_path == "Empty filename"){
                header("Location: user_files.php");
        }
        else{

        if( move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $full_path) ){
                
                header("Location: user_files.php");

                exit;
        }else{
                header("Location: upload_fail.html");
                exit;
        }
        }
}
else{
        header("Location: file_sharing_login.php");
}

?>