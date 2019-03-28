<?php
session_start();
include 'file_script.php';
//displays file in new tab
ini_set('display_errors', 1);
error_reporting(E_ALL|E_STRICT);
$file = $_GET['filename'];
$username = $_SESSION['username'];

display_file_contents($file,$username);

?>