<!DOCTYPE html>
<html lang='en'>

<head>  
    <link rel="stylesheet" type = "text/css" href="main_stylesheet.css"/>
    <title>Login Page</title>
</head>
<body>
    <br><header><b>News Site</b></header>
    <div class = "box"> 
        <h1>Sign Up</h1>

    <form method = "POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
        <label for = "username">Username: </label>
        <input type = "text" name = "username" id = "username" value="<?php if(isset($_POST['username'])){echo htmlentities($_POST['username']);}?>"/>
        <br>

        <label for = "password">Password: </label>
        <input type = "password" name = "password" id = "password" value="<?php if(isset($_POST['password'])){echo htmlentities($_POST['password']);}?>"/>
        
        <br>

        <label for = "conf_password">Confirm Password: </label>
        <input type = "password" name = "conf_password" id = "password"/>
        
        <br>
        <label for = "first_name">First Name: </label>
        <input type = "text" name = "first_name" id = "first_name" value="<?php if(isset($_POST['first_name'])){echo htmlentities($_POST['first_name']);}?>"/>
        
        <br>
        <label for = "last_name">Last Name: </label>
        <input type = "text" name = "last_name" id = "last_name" value="<?php if(isset($_POST['last_name'])){echo htmlentities($_POST['last_name']);}?>"/>
        
        <br>
        
        <input type = "submit" value = "Create New User"/>
        <button formaction="logout.php"> Return to Login</button>
        
    </form>
    
    </div>

     <?php
     require 'database.php';
        // check to see if the username is taken
        if(isset($_POST['username']) && isset($_POST['password'])&& isset($_POST['conf_password'])&& isset($_POST['first_name'])&& isset($_POST['last_name'])){
            session_start();
            $user_name = $_POST['username'];
            $password = $_POST['password'];
            $conf_password = $_POST['conf_password'];
            
            $user_check = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
            if($user_check){
                $user_check->bind_param('s', $user_name);
                $user_check -> execute();
                $result = $user_check ->get_result();
                $row_cnt = mysqli_num_rows($result);
                
                if($row_cnt ==0){

                    //if username validation passes, check to see 
                    //that the password is secure enough and that they match
                    
                    if(strlen($password) >= 8 && strlen($password)<=25 && ctype_alnum($password)){

                        if(strcmp($password,$conf_password) == 0 ){
                            $_SESSION['password']=$_POST['password'];
                            $_SESSION['username']=$_POST['username'];
                            $_SESSION['first_name'] = $_POST['first_name'];
                            $_SESSION['last_name'] = $_POST['last_name'];
                            header('Location: create_user_script.php');
                        }
                        else{
                            echo("Passwords do not match. Please try again");
                        
                        }
                    }
                    else{
                        echo("Password invalid. The password must be between 8 and 25 characters and must be alphanumeric characters");
                    }

                }
                else{
                    printf("Username taken! Please input a different username");
                }
            }
          
        }
?> 
</body>

</html>
