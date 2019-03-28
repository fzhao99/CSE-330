<?php
    if(isset($_POST['username'])){
        session_destroy();
        header("Location: file_sharing_login.php");
    }
    else{
        header("Location: file_sharing_login.php");
}
?>
