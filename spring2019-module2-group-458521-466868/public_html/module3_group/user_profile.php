<!DOCTYPE html>
<html lang='en'>
<head>
    <link rel = "stylesheet" type = "text/css" href = "main_stylesheet.css"/>
    <link href="https://fonts.googleapis.com/css?family=Oswald%7CRoboto+Slab%7CSlabo+27px" rel="stylesheet">
        <title> News Site </title>
</head>
<body>
    <div class = "login">
        <form action = "user_profile.php">
            <input type = "submit" value = "Profile">
        </form>
        <form action = "logout.php">
            <input type = "submit" value = "Logout"/>
        </form>
    </div>
    <div class = 'welcome'>
    <?php session_start(); if(isset($_SESSION['user_id'])){echo sprintf("Welcome, %s", $_SESSION['username']);}?>
    </div>
    <a href = 'logged_in_landingpage.php' target = '_self' id = 'newssite' style = 'text-align: center' >News Site</a>
    <form action = 'create_story.php' id = 'stories'>
        <input type = 'submit' name = 'create' value = 'Create Story'>
    </form>
    <h1> Your Stories </h1>
<?php
    require 'database.php';
    $user_id = $_SESSION['user_id'];
    $stmt = $mysqli->prepare("select story_ID, title, users.first_name, users.last_name, summary, date_posted, story_link from stories join users on (stories.author_ID=users.pk_user_ID) where users.pk_user_ID = ? order by date_posted asc;");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
   
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->bind_result($story_ID, $story_title, $author_first, $author_last, $story_summary, $time_added, $story_site);

    //display edit/delete scripts, along with the links to the file based on whether a link is associated with stories
    while($stmt->fetch()){
        $edit_link = "<a href= 'script_display_story_contents.php?story_ID=%d' class=\"change_links\" target='script_display_story_contents.php'>Edit Story</a>";
        $delete_link = "<a href= 'script_delete_story.php?story_ID=%d' class=\"change_links\" target='script_delete_story.php'>Delete Story</a>";

            
        if($story_site == null){
            $file_link ="<a href= 'logged_in_view.php?story_ID=%dstory_name=%s' target='logged_in_view.php' class ='story_title'>%s</a>";
            echo (sprintf($file_link, $story_ID, htmlspecialchars($story_title),htmlspecialchars($story_title)));
            echo sprintf("<div class ='author'><b>By: %s %s </b>",htmlentities($author_first),htmlentities($author_last));
            echo sprintf("</div>");
        }
        else{
            $file_link = "<a href= '//%s' target='logged_in_view.php' class ='story_title'>%s</a><br>";
            echo sprintf($file_link, $story_site, htmlspecialchars($story_title));
            echo sprintf("<div class ='author'><b>By: %s %s </b>",htmlentities($author_first),htmlentities($author_last));
            echo sprintf("</div>");
        }
       


        if($story_summary!=null){
            echo sprintf("</div><div class='summary' id = 'stories'> %s </div><br>", $story_summary);
        }
            
    }
    $stmt->close();

?>
<h1> Your Comments <h1>
<?php 
    require 'database.php';
    $user_id = $_SESSION['user_id'];
    $stmt2 = $mysqli->prepare("select comments.story_ID, comment_ID, comments.user, user_comment, stories.title from comments join stories on (stories.story_ID = comments.story_ID) where comments.user = ? order by comments.date_posted asc;");
    if(!$stmt2){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt2->bind_param('i', $user_id);
    $stmt2->execute();
    $stmt2->bind_result($story_ID2, $comment_num2, $user_num2, $comment2, $story_title2);

    while($stmt2->fetch()){
        
        $file_link = "<a href= 'logged_in_view.php?story_ID=%dstory_name=%s' target='_self' id = 'stories'>%s</a><br>";
       
        echo sprintf($file_link, $story_ID2, htmlspecialchars($story_title2),htmlspecialchars($story_title2));

        echo sprintf("<div class='comments' id = 'stories'>Your comment: %s</div><br>", $comment2);
            
    }

    echo "</ul>\n";
    $stmt2->close();
?>

</body>
</html>