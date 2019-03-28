<!DOCTYPE html>
<html lang='en'>
<head>
	<link rel = "stylesheet" type = "text/css" href = "main_stylesheet.css"/>
    <link href="https://fonts.googleapis.com/css?family=Oswald|Roboto+Slab|Slabo+27px" rel="stylesheet">
    <title> Article </title>
</head>

<body>
 
<?php
require 'database.php';
session_start();
if(isset($_SESSION['user_id'])){
    echo('<div class = "login">
            <form action = "user_profile.php" class = "profile">
                <input type = "submit" value = "Profile">
            </form>
            <form action = "logout.php" class = "logout">
                <input type = "submit" value = "Logout"/>
            </form>
        </div>');

echo("<div class= 'welcome'>");

    echo sprintf("Welcome, %s", $_SESSION['username']);

echo('</div>');
echo("<a href = 'logged_in_landingpage.php' target = '_self' id = 'newssite'' >News Site</a>");

}
else{
    echo('<div class = "login">
        
    <form action = "news_site_login.php">
        <input type = "submit" value = "Login / Signup"/>
    </form>
    
    </div>');

}
echo("</div>");

$file_num = $_GET['story_ID'];
$story = sprintf("select story_id, title, users.first_name, users.last_name, story_contents, date_posted from stories join users on author_ID = users.pk_user_ID where story_ID = %d", $file_num);
$stmt = $mysqli->prepare($story);
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();

$stmt->bind_result($story_ID,$story_title, $author_first, $author_last, $story_content, $date);


while($stmt->fetch()){
	
	echo sprintf("<div class = 'title' id = 'stories'>%s</div><br><div class='author' id = 'stories'>By: %s %s<br>Date posted: %s</div><br><div class='story' id = 'stories'>%s</div>", $story_title, $author_first, $author_last, $date, $story_content);
	
}


if(isset($_SESSION['user_id'] )){

echo sprintf("<h2>Comments</h2>");
echo ("<form method = 'POST'>");
echo ("<input type = 'text' maxLength = 500 name = 'comment'> ");
echo ("<input type = 'submit' name = 'add_comment' value = 'Add Comment'>");
echo ("</form>");
}

echo("<br><br>");
    include 'script_comment.php';

    if(isset($_POST['comment'])){
        add_comment($_POST['comment'], $story_ID);
        header(sprintf("Location: logged_in_view.php?story_ID=%dstory_name=%s",$story_ID, $story_title));
    }

    $stmt->close();
    $comments = sprintf("select comment_ID,comments.date_posted, users.pk_user_id, users.first_name, users.last_name, user_comment from comments join users on comments.user = users.pk_user_id join stories on comments.story_ID = stories.story_ID where comments.story_ID = %d", $file_num);
    $stmt2 = $mysqli->prepare($comments);
    if(!$stmt2){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }


echo ("<div class='comments'>");
$stmt2->execute();
$stmt2->bind_result($comment_ID,$post_date,$com_author_ID, $com_author_first, $com_author_last, $comment_content);
$_SESSION['url_to_return_to'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

while($stmt2->fetch()){
	$edit_link = "<a href= 'script_display_comment.php?comment_ID=%d' class=\"change_links\" target='script_display_comment.php'>Edit Comment</a>";
    $delete_link = "<a href= 'script_delete_comment.php?comment_ID=%d' class=\"change_links\" target='script_delete_comment.php'>Delete Comment</a>";
    
    echo("<div class = 'entry'>");
    echo ("Posted: ".$post_date);
    if(isset($_SESSION['user_id'] )){
        if($_SESSION['user_id'] == $com_author_ID){
            echo sprintf($edit_link,$comment_ID);
            echo sprintf($delete_link,$comment_ID);
        }
    }
    echo sprintf("<br><b>%s %s</b><br>%s<br><br>",$com_author_first, $com_author_last, $comment_content);
    echo("</div>");
}

$stmt2->close();
echo ("</div>");

?>


</body>

</html>