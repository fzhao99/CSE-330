<?php
    session_start();
    if(session_status()==2){
        session_destroy();
        header("Location: logged_in_landingpage.php");
    }
  
?>
