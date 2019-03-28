<?php
require 'database.php';

$pass_to_hash = $_POST['password'];
$username = $_POST['username'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];


$hashed_pass = password_hash($pass_to_hash,PASSWORD_DEFAULT);

$user_check = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
if($user_check){
    $user_check->bind_param('s', $username);
    $user_check -> execute();
    $result = $user_check ->get_result();
    $row_cnt = mysqli_num_rows($result);

    if($row_cnt ==0){

            $stmt = $mysqli->prepare("INSERT INTO users (username,salted_password, first_name, last_name) VALUES (?,?) ");
            if($stmt){
                $stmt->bind_param('ss', $username,$hashed_pass);
                $stmt->execute();
                $stmt->close();
            }
            else{
                printf('Error num: %d, error: %s', $mysqli-> errno, $mysqli->error );
                die;
            }
        }
    }
    else{
        printf("Username taken!");
    }
    

?>