<?php

if(isset($_POST['username'])){

        session_start();
        include 'file_script.php';

        if(!isset($_FILES['file_upload']) || $_FILES['file_upload']['error'] == UPLOAD_ERR_NO_FILE) {
                echo htmlentities("Error no file selected"); 
        } else {
                print_r("%s",htmlentities(($_FILES)));
        }
        //saves the time that the file was created
        $filename = basename($_FILES['uploadedfile']['name']);
        $username = $_SESSION['username'];
        $date = date('Y-m-d H:i:s');

        //  function from file_script.php
        $full_path = generate_file_path($filename, $username);

        //checks for errors in the file name
        if($full_path == "Invalid filename"){
                header("Location: filename_invalid.html");
        }
        elseif($full_path == "Empty filename"){
                header("Location: filename_empty.html");
        }
        else{
        //adds file to user's folder
                if( move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $full_path) ){
                        
                        header("Location: user_files.php");

                        exit;
                }else{
                        header("Location: upload_fail.html");
                        exit;
                }
        }
}
else {
        header("Location: file_sharing_login.php");
}

?>