<!DOCTYPE html>
<html lang='en'>

<head>
    <link rel = "stylesheet" type = "text/css" href = "main_stylesheet.css"/>
    <link href="https://fonts.googleapis.com/css?family=Oswald|Roboto+Slab|Slabo+27px" rel="stylesheet">
    <title> News Site </title>
</head>
<body>
    <div class = "login">
        <form action = "news_site_login.php">
            <input type = "submit" value = "Login / Signup"/>
        </form>
    </div>

    <a href = 'landingpage.php' target = '_self' id = 'newssite' style = 'text-align: center' >News Site</a>
    <h1> Stories </h1>


<?php
    require 'database.php';
    session_start();
    $stmt = $mysqli->prepare("select story_ID, title, users.first_name, users.last_name, users.username, summary, date_posted, story_link from stories join users on (stories.author_ID=users.pk_user_ID) order by date_posted asc;");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt->execute();
    $stmt->bind_result($story_ID, $story_title, $author_first, $author_last,$author_username, $story_summary, $time_added, $story_site);

    echo "<ul>\n";

    while($stmt->fetch()){

        $file_link = "<a href= 'logged_in_view.php?story_ID=%dstory_name=%s' target='logged_in_view.php' style='margin-left:80px'>%s</a>";


        echo sprintf($file_link, $story_ID, htmlspecialchars($story_title),htmlspecialchars($story_title));
        if(isset($_SESSION['user_id'] )){
            if($_SESSION['user_id'] == $com_author_id){
                echo sprintf($edit_link,$comment_ID);
                echo sprintf($delete_link,$comment_ID);
            }
        }
        
        echo("<br>");
        echo sprintf("<div class='author'><b>By: %s %s</b> ", htmlentities($author_first), htmlentities($author_last));

        if($story_summary!=null){
            echo sprintf("</div><div class='summary' id = 'stories'> %s </div><br>", $story_summary);
        }

    }
    echo "</ul>\n";
    $stmt->close();
?>

</body>
