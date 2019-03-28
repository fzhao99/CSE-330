<?php
 
    session_start();
   
    session_destroy();
    header("Location: file_sharing_login.php");
   
?>
