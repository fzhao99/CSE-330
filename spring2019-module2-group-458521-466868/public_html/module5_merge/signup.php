
     <?php
     require 'database.php';
     ini_set("session.cookie_httponly", 1);

        // check to see if the username is taken
        header("Content-Type: application/json");
        $json_str = file_get_contents("php://input");
        $json_obj = json_decode($json_str, true);

        $first_name = $json_obj['first_name'];
        $last_name = $json_obj['last_name'];
        $username = $json_obj['new_username'];
        $password = $json_obj['new_password'];
        $conf_password = $json_obj['confirm_password'];
 
        if(strlen($username)>0 && strlen($password)>0 && strlen($conf_password)>0 && strlen($first_name) >0 && strlen($last_name)>0){
            session_start();
            $user_check = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
            if($user_check){
                $user_check->bind_param('s', $username);
                $user_check -> execute();
                $result = $user_check ->get_result();
                $row_cnt = mysqli_num_rows($result);
                
                if($row_cnt ==0){

                    //if username validation passes, check to see 
                    //that the password is secure enough and that they match
                    
                    if(strlen($password) >= 8 && strlen($password)<=25 && ctype_alnum($password)){

                        if(strcmp($password,$conf_password) == 0 ){
                            $_SESSION['password']=$password;
                            $_SESSION['username']=$username;
                            $_SESSION['first_name'] = $first_name;
                            $_SESSION['last_name'] = $last_name;
                            $hashed_pass = password_hash($password,PASSWORD_DEFAULT);

                            $stmt = $mysqli->prepare("INSERT INTO users (username,first_name, last_name, salted_password) VALUES (?,?,?,?) ");
                            if($stmt){
                                $stmt->bind_param('ssss', $username, $first_name, $last_name, $hashed_pass);
                                $stmt->execute();
                                $stmt->close();
                                
                                echo json_encode(array("success"=>true));
                                die;
                            }
                            else{
                                echo json_encode(array(
                                    "success"=>false, 
                                    "message"=>sprintf('error: %s', $mysqli->error)));
                                die;
                            }
                        }
                        else{
                            echo json_encode(array(
                                "success"=> false,
                                "message"=>"Passwords do not match. Please try again"));
                            die;
                        }
                    }
                    else{
                        echo json_encode(array(
                            "success"=>false,
                            "message"=>"Password invalid. The password must be between 8 and 25 characters and must be alphanumeric characters"));
                        die;
                    }

                }
                else{
                    echo json_encode(array(
                        "success"=> false,
                        "message"=>"Username taken! Please input a different username"));
                    die;
                }
            }
            echo json_encode(array(
                "success"=>false,
                "message"=>"mysql statement failed"
            ));
            die;
        }
        else {
            echo json_encode(array(
                "success"=>false,
                "message"=>"Please fill in all fields!"
            ));
            die;
        }
?> 

