<?php
require 'database.php';
ini_set("session.cookie_httponly", 1);

session_start();

$pass_to_hash = $_SESSION['password'];
$user_name = $_SESSION['username'];
$first = $_SESSION['first_name'];
$last = $_SESSION['last_name'];


$hashed_pass = password_hash($pass_to_hash,PASSWORD_DEFAULT);

$stmt = $mysqli->prepare("INSERT INTO users (username,first_name, last_name, salted_password) VALUES (?,?,?,?) ");
if($stmt){
    $stmt->bind_param('ssss', $user_name, $first, $last, $hashed_pass);
    $stmt->execute();
    $stmt->close();
    $_SESSION['user_just_created'] = true;

    header("Location: calendar_login.php");
}
else{
    printf('Error num: %d, error: %s', $mysqli-> errno, $mysqli->error );
    die;
}

    

?>