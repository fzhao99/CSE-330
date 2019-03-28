<?php

session_start();

if(isset($_SESSION['username'])){

function generate_file_path($filename, $username){
    if($filename == ""){
        return "Empty filename";
    }
    
    if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
        return "Invalid filename";
    }

    if( !preg_match('/^[\w_\-]+$/', $username) ){
        return "Invalid username";
    }
    $dirpath = "/var/www/user_files/%s_files/%s";
    $full_path = sprintf($dirpath,$username, $filename);
    return $full_path;
}

function display_file_contents($filename,$username){
    $filepath = generate_file_path($filename,$username);
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($filepath);

    
    header(sprintf("Content-Type: %s", htmlentities($mime)));
    ob_clean();
    flush();
    readfile($filepath);
        
}

function delete_file($filename, $username){
    $filepath = generate_file_path($filename,$username);
    if(unlink($filepath)){
        return true;
    }
    else{
        return false;
    }
    ;
    
}

function rename_file($filename, $username){
    
}
}

else{
    header("Location: file_sharing_login.php");
}
?>

