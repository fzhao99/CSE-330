<!DOCTYPE html>
<html lang='en'>
<head>
    <link rel="stylesheet" type="text/css" href="landingpage_stylesheet.css"/>
    <link href="https://fonts.googleapis.com/css?family=Bree+Serif" rel="stylesheet"/>
    <title> Landing Page </title>
</head>
<body>
    <h1>Welcome, <?php session_start(); echo($_SESSION['username'])?></h1>
     
    <div class = "logout">
        <form action = "logout.php">
            <input type = "submit" value = "Logout"/>
        </form>
    </div>
    <div class = "box">
    <header>File Sharing Site</header>
    </div>
    <div class = "files">
        
        <div class = "upload">
            <form enctype="multipart/form-data" action = "upload.php" method="POST">
                <input type ="hidden" name="MAX_FILE_SIZE" value="20000000"/>
                <label for="uploadfile_input"> Choose a file to upload: </label><input name="uploadedfile" type="file" id="uploadfile_input"/>
                <br>
                <input type = "submit" value = "Upload"/>


            </form>
        </div>
        <div class = "row">
            <div class = "column left">
                <h2>Files</h2>
<?php
session_start();

if(isset($_SESSION['username'])){
   
    include 'file_script.php';

    $username = $_SESSION['username'];
    $directory = "/var/www/user_files/".$username."_files/";
    $time_uploaded = getdate();
    $_SESSION['directory'] = array_diff(scandir($directory),array('..','.'));
    
    echo sprintf("<form method = 'POST'>");
    echo sprintf("<input type = 'submit' name = 'delete' value = 'Delete'>");
    echo sprintf("<input type = 'submit' name = 'rename' value = 'Rename'><br><br>");
    date_default_timezone_set('America/Chicago');

    /*echo sprintf("<form method = 'GET'>");*/

    foreach($_SESSION['directory'] as $key => $file){
        $filepath =  generate_file_path($file, $username);
        
        $file_link = '<a href="logged_in_view.php?filename=%s" target="_blank">%s</a><br>';
        $delete_file = "delete.php?filename=$file";

       
        /*echo sprintf("<div class = 'file_display'>");*/
        echo sprintf("<input type='radio' name = 'file' value = $file>");
        echo sprintf($file_link,htmlentities($file),htmlentities($file));             
       /* echo sprintf("<a href=$delete_file class = 'button'> Delete </a>
            </div>"); */
               

        $file_upload_date = date('m/d/Y', filemtime($filepath));
        $file_upload_time = date('h:i:A ', filemtime($filepath));
        echo sprintf("Uploaded on %s at %s<br><br>", $file_upload_date, $file_upload_time );        
        /*echo sprintf("</div>");   */       

    } 
    echo ("</form>");
   
    if(isset($_POST['file'])){
        if(isset($_POST['rename'])){
            $_SESSION['temp_rename_file'] = $_POST['file'];
            header("Location: rename.php");
        } else if(isset($_POST['delete'])){
            $_SESSION['temp_delete_file'] = $_POST['file'];
            header("Location: delete.php");
        } else {

        }
    }
}
else{
    header("Location: file_sharing_login.php");
}

?>
    </div>
       <div class  = "column right">
            <h2>Recently Deleted Files</h2>
            
<?php
        //print_r($_SESSION['deleted_files']);
        if(isset($_SESSION['deleted_files'])){
            foreach($_SESSION['deleted_files'] as $key=>$file){
                echo sprintf($file."<br>");
            }
        }
        
        //echo($_SESSION['deleted_files']);
        
?>
        </div>
</div>
</div>

</body>
</html>
