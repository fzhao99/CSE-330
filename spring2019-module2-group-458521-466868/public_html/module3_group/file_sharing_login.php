<!DOCTYPE html>
<html lang='en'>

<head>  
    <link rel="stylesheet" type = "text/css" href="login_stylesheet.css"/>
    <title>Login Page</title>
</head>
<body>
    <br><header><b>File Sharing Site</b></header>
    <div class = "box"> 
        <h1>Login</h1>

    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method = "POST">
        <label for = "username">Username: </label>
        <input type = "text" name = "username" id = "username"/>
        <input type = "submit" value = "Login"/>
        <button type = "submit" formaction = "new_user.php">Sign Up</button>
    </form>
    </div>
<?php

   
   
   if($_SERVER['REQUEST_METHOD'] == "POST"){
        session_start();
        $file = fopen("/var/www/user_files/users.txt","r");
        
        //checks to see if submitted username is one of the given usernames in users.txt
        while(!feof($file)){
            $value1 = htmlentities(trim($_POST['username']));
            $value2 = htmlentities(trim(fgets($file)));
            if(strcmp($value1, $value2)==0){
                $_SESSION['username'] = $value1;
                echo ($_SESSION['username']);
                fclose($file);
                header("Location: user_files.php");
                exit;
            } 
        }
        printf("%s",htmlentities("INVALID USERNAME"));
        fclose($file);
        
      
    }
    
?>
</body>

</html>
