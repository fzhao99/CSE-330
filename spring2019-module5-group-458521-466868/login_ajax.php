<?php
    require 'database.php';
    ini_set("session.cookie_httponly", 1);

    header("Content-Type: application/json");


    $json_str = file_get_contents("php://input");
    $json_obj = json_decode($json_str,true);
    // $json_obj = json_decode($json_str, true);

    $username = $json_obj['username'];
    $pwd = $json_obj['password'];


    $user_check = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
    if($user_check){
        $user_check->bind_param('s', $username);
        $user_check -> execute();
        $result = $user_check ->get_result();
        $row_cnt = mysqli_num_rows($result);

        if($row_cnt == '1'){
                $stmt = $mysqli->prepare("SELECT COUNT(*), pk_user_ID, salted_password FROM users WHERE username=?");
                if($stmt){
                    // Bind the parameter
                    $stmt->bind_param('s', $username);
                    $stmt->execute();

                    // Bind the results
                    $stmt->bind_result($cnt, $user_id, $pwd_hash);
                    $stmt->fetch();

                    $pwd_guess = $pwd;
                    // Compare the submitted password to the actual password hash

                    if($cnt == 1 && password_verify($pwd_guess, $pwd_hash)){
                        session_start();
                        $_SESSION['username'] = $username;
                        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));

                        echo json_encode(array(
                            "success" => true,
                            "token" => $_SESSION['token']
                        ));
                        exit;
                    } else {
                        echo json_encode(array(
                            "success" => false,
                            "message" => "Incorrect Username or Password"
                        ));
                        exit;
                    }
                }
                else{
                    echo json_encode(array(
                        "success" => false,
                        "message" => "User unique statement never validated"
                    ));
                }

            } else {
                echo json_encode(array(
                    "success" => false,
                    "message" => "Incorrect Username or Password"
                ));
                exit;
            }
           
        }
        else{
            echo json_encode(array(
                "success" => false,
                "message" => "User check statement never validated"
            ));
        }
?>
