<!DOCTYPE html>
<html lang='en'>

<head>
    <link rel = "stylesheet" type = "text/css" href = "main_stylesheet.css"/>
    <link href="https://fonts.googleapis.com/css?family=Oswald%7CRoboto+Slab%7CSlabo+27px" rel="stylesheet">
    <title> News Site </title>
</head>
<body>
<a class= "new_story" href = 'logged_in_landingpage.php' target = '_self' id = 'newssite' style = 'text-align: center' >News Site</a>

<?php
    
    require 'database.php';
    session_start();
    //header logic for login/profile/logout buttons
    echo("<div class = 'stories'>");
    if(isset($_SESSION['user_id'])){
        echo('<div class = "login">
                <form action = "user_profile.php" class = "profile">
                    <input  type = "submit" value = "Profile">
                </form>
                <form action = "logout.php" class = "logout">
                    <input  type = "submit" value = "Logout"/>
                </form>
            </div>');
    
    echo("<div class= 'welcome'>");
    
        echo sprintf("Welcome, %s", $_SESSION['username']);
    
    echo('</div>');
    
    }
    else{
        echo('<div class = "login">
            
        <form action = "news_site_login.php">
            <input type = "submit" value = "Login / Signup"/>
        </form>
        
        </div>');
    
    }
    echo("</div>");
    
   
    echo('<h1 class= "inline_header"> Stories </h1><br>');

    if(isset($_SESSION['user_id'])){
    echo('<form class="inline_form" action = "create_story.php">
        <input class = "new_story" type = "submit" value = "Create New Story"/>
    </form><br><br>');
    }
    
    //tag creation for story searching
    echo sprintf(" <a href = 'logged_in_tagged_stories.php?tag=Sports' target = '_self' class = 'tags'> Sports &nbsp;</a>");
    echo sprintf(" <a href = 'logged_in_tagged_stories.php?tag=Entertainment' target = '_self' class = 'tags'> Entertainment &nbsp;</a>");
    echo sprintf(" <a href = 'logged_in_tagged_stories.php?tag=Politics' target = '_self' class = 'tags'> Politics &nbsp;</a>");
    echo sprintf(" <a href = 'logged_in_tagged_stories.php?tag=Business' target = '_self' class = 'tags'> Business &nbsp;</a>");
    echo sprintf(" <a href = 'logged_in_tagged_stories.php?tag=Opinion' target = '_self' class = 'tags'> Opinion &nbsp;</a>");
    echo sprintf(" <a href = 'logged_in_tagged_stories.php?tag=Tech' target = '_self' class = 'tags'> Tech &nbsp;</a>");
    echo sprintf(" <a href = 'logged_in_tagged_stories.php?tag=Science' target = '_self' class = 'tags'> Science &nbsp;</a>");
    echo sprintf(" <a href = 'logged_in_tagged_stories.php?tag=Health' target = '_self' class = 'tags'> Health &nbsp;</a>");
    echo sprintf(" <a href = 'logged_in_tagged_stories.php?tag=Arts' target = '_self' class = 'tags'> Arts &nbsp;</a>");
    echo sprintf(" <a href = 'logged_in_tagged_stories.php?tag=Books' target = '_self' class = 'tags'> Books &nbsp;</a>");
    echo sprintf(" <a href = 'logged_in_tagged_stories.php?tag=Style' target = '_self' class = 'tags'> Style &nbsp;</a>");
    echo sprintf(" <a href = 'logged_in_tagged_stories.php?tag=Food' target = '_self' class = 'tags'> Food &nbsp;</a>");
    echo sprintf(" <a href = 'logged_in_tagged_stories.php?tag=Travel' target = '_self' class = 'tags'> Travel &nbsp;</a>");
    echo sprintf(" <a href = 'logged_in_tagged_stories.php?tag=Miscellaneous' target = '_self' class = 'tags'> Misc. </a>");

    $stmt = $mysqli->prepare("select story_ID, author_ID, title, users.first_name, users.last_name, summary, date_posted, story_link from stories join users on (stories.author_ID=users.pk_user_ID) order by date_posted asc;");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt->execute();
    $stmt->bind_result($story_ID, $author_ID,$story_title, $author_first, $author_last, $story_summary, $time_added, $story_site);

    //display the stories gathered from the database
    echo("<div class = 'all_stories'>");
    while($stmt->fetch()){

        $file_link = "";
        $edit_link = "<a href= 'script_display_story_contents.php?story_ID=%d' class=\"change_links\" target='script_display_story_contents.php'>Edit Story</a>";
        $delete_link = "<a href= 'script_delete_story.php?story_ID=%d' class=\"change_links\" target='script_delete_story.php'>Delete Story</a>";

        echo("<div class = 'entry'>");

        if($story_site == null){
            $file_link ="<a href= 'logged_in_view.php?story_ID=%dstory_name=%s' target='logged_in_view.php' class ='story_title'>%s</a>";
            echo (sprintf($file_link, $story_ID, rawurlencode(htmlspecialchars($story_title)),htmlspecialchars($story_title)));
            echo sprintf("<div class ='author'><b>By: %s %s </b>",htmlentities($author_first),htmlentities($author_last));
        }
        else{
            $file_link = "<a href= '//%s' target='logged_in_view.php' class ='story_title'>%s</a><br>";
            echo sprintf($file_link, $story_site, htmlspecialchars($story_title));
            echo sprintf("<div class ='author'><b>By: %s %s </b>",htmlentities($author_first),htmlentities($author_last));
        }

        if( isset($_SESSION['user_id']) && $_SESSION['user_id'] == $author_ID){
            echo ("<b>");
            echo sprintf($edit_link,$story_ID);
            echo sprintf($delete_link,$story_ID);
            echo ("</b>");
            
        }
        echo sprintf("</div>");
        
        if($story_summary!=null){
            echo sprintf("</div><div class='summary stories'> %s </div><br>", $story_summary);
        }
        echo("</div>");

            
    }
    echo("</div>");
    
    $stmt->close();
?>
</body>