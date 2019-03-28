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
<?php
    require 'database.php';
    $tag = $_GET['tag'];
    echo sprintf("<h1>%s</h1>", $tag);
    $stmt = $mysqli->prepare("select story_ID, title, users.first_name, users.last_name, summary, date_posted, story_link from stories join users on (stories.author_ID=users.pk_user_ID) where stories.story_tag = ? order by date_posted asc;");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('s', $tag);
    $stmt->execute();
    $stmt->bind_result($story_num, $story_title, $author_first, $author_last, $story_summary, $time_added, $story_site);
    echo "<ul>\n";
    while($stmt->fetch()){

        $file_link = "<a href= 'view.php?story_num=%dstory_name=%s' target='_self' id = 'stories'>%s</a><br>";
        echo sprintf($file_link, $story_num, htmlspecialchars($story_title),htmlspecialchars($story_title));

        echo sprintf("<div class='author' id = 'stories'><b>By: %s %s</b><br>", $author_first, $author_last);
        if($story_summary!=null){
            echo sprintf("</div><div class='summary' id = 'stories'> %s </div><br>", $story_summary);
        }
            
    }
    echo "</ul>\n";
    $stmt->close();
?>
</body>
</html>