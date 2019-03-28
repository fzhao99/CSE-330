<!DOCTYPE html>
<html lang='en'>

<head>  
    <link rel="stylesheet" type = "text/css" href="main_stylesheet.css"/>
    <title>Login Page</title>
</head>
<body>
<a href = 'landingpage.php' target = '_self' id = 'newssite' style = 'text-align: center' >News Site</a>

    <div class = "box"> 
        <h1>Login</h1>

    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method = "POST">
        <label for = "username">Username: </label>
        <input type = "text" name = "username" id = "username"/>
        <br>

        <label for = "password">Password: </label>
        <input type = "password" name = "password" id = "password"/>
        <br>

        <input type = "submit" value = "Login"/>
        <button type = "submit" formaction = "signup.php">Sign Up</button>
    </form>
    </div>
<?php

require 'database.php';
session_start();

   if($_SERVER['REQUEST_METHOD'] == "POST"){
       
        $username = $_POST['username'];

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

                        $pwd_guess = $_POST['password'];
                        // Compare the submitted password to the actual password hash

                        if($cnt == 1 && password_verify($pwd_guess, $pwd_hash)){
                            // Login succeeded!
                            $_SESSION['user_id'] = $user_id;
                            $_SESSION['username'] = $username;
                            $_SESSION['token'] =  bin2hex(random_bytes(32));
                        header("Location: main.html");                            
                        } else{
                            // Login failed; redirect back to the login screen
                            header('refresh:1000; url=calendar_login.php');
                            echo("Login failed. Please check your credentials and try again.");
                        }

                        exit;
                    }
                }

            
            if($row_cnt == '0'){
                printf("Username not found. Please sign up before proceeding.");
            }
            } 
        }
        if(isset($_SESSION['user_just_created'])){
            $_SESSION['user_just_created'] = false;
            echo("Success! User created. Please login to view your content");
        }        
      
    
    
?>
</body>

</html>
