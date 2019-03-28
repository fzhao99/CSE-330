<?php

session_start();

if(isset($_SESSION['username'])){

include 'file_script.php';
ini_set('display_errors', 1);
error_reporting(E_ALL|E_STRICT);
$file = $_GET['filename'];
$username = $_SESSION['username'];

display_file_contents($file,$username);
}
else{
    header("Location: file_sharing_login.php");
}
?>