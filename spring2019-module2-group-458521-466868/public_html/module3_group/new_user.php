<!DOCTYPE html>
<html lang='en'>

<head>  
    <link rel="stylesheet" type = "text/css" href="login_stylesheet.css"/>
    <title>Login Page</title>
</head>
<body>
    <br><header><b>File Sharing Site</b></header>
    <div class = "box"> 
        <h1>Sign Up</h1>

    <form method = "POST" action = "create_user.php">
        <label for = "username">New Username: </label>
        <input type = "text" name = "username" id = "username" value="<?php if(isset($_POST['newusername'])){echo htmlentities($_POST['newusername']);}?>"/>
        
        <label for = "username">Password: </label>
        <input type = "text" name = "password" id = "username" value="<?php if(isset($_POST['newusername'])){echo htmlentities($_POST['newusername']);}?>"/>
        
        <input type = "submit" value = "Create New User"/>
        <button formaction="logout.php"> Return to Login</button>
        
    </form>
    
    </div>

     <?php
        
    //     if(isset($_POST['newusername'])){
    //         session_start();
    //         $file = fopen("/var/www/user_files/users.txt","r+");
    //         while(!feof($file)){
    //         $value1 = htmlentities(trim($_POST['newusername']));
    //         $value2 = htmlentities(trim(fgets($file)));
    //         if(strcmp($value1, $value2)==0){
    //             if($value1 == ""){
    //                 echo(htmlentities("Please input a username"));
    //             }
    //             else{
    //                 echo (htmlentities("User name taken already. Please input a different username"));
    //             }
    //             exit;
    //         } 
    //     }
    //     if(iconv_strlen($_POST['newusername'])<=16 && ctype_alnum($_POST['newusername'])){
    //         $username = $_POST['newusername']."\n";
    //         $pathname = "/var/www/user_files/".$_POST['newusername']."_files/";
    //         shell_exec("mkdir ".$pathname);
    //         fwrite($file,$username);
    //         echo(htmlentities("Success! User has been created."));
            
    //     }
    //     else{
    //         echo(htmlentities("Username is unacceptable. Please limit to under 16 characters and do not include non-alphanumeric characters"));
    //     }
    //     fclose($file);

    // }
?> 
</body>

</html>
