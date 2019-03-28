<!DOCTYPE html>
<html lang='en'>
<head>
	<link rel = "stylesheet" type = "text/css" href = "main_stylesheet.css"/>
    <link href="https://fonts.googleapis.com/css?family=Oswald|Roboto+Slab|Slabo+27px" rel="stylesheet">
    <title> Article </title>
</head>

<body>

<form action=<?php echo $_SERVER['PHP_SELF'] ?> method = "POST">

<label for = "title">Title: </label><br>
<textarea name = "title" class = "edit" id = "title" ></textarea>
<br>

<label for = "summary">Summary: </label> <br>
<textarea name = "summary" class = "edit" id = "summary"></textarea>
<br>


<label for = "content">Content: </label> <br>
<textarea name = "content" class = "edit" id = "content" ></textarea>
<br>

<label for = "link">Link: </label> <br>
<textarea name = "link" class = "edit" id = "link" ></textarea>
<br>

<label for = "tags">Tags: </label> <br>
<select name= "tags", id="select_tags" >
<option value = "NULL" selected>None</option>
<option value = "Miscellaneous">Misc</option>
<option value = "Travel">Travel</option>
<option value = "Food">Food</option>
<option value = "Style">Style</option>
<option value = "Books">Books</option>
<option value = "Arts">Arts</option>
<option value = "Health">Health</option>
<option value = "Science">Science</option>
<option value = "Tech">Tech</option>
<option value = "Opinion">Opinion</option>
<option value = "Business">Business</option>
<option value = "Politics">Politics</option>
<option value = "Entertainment">Entertainment</option>
<option value = "Sports">Sports</option>

</select>
<br>
<input class ="story_submit" type = "submit" value = "Save"/>
</form>



<?php
require 'database.php';
session_start();
   if($_SERVER['REQUEST_METHOD'] == "POST"){

    $new_title = $_POST['title'];
    $new_summary = $_POST['summary'];
    $new_content = $_POST['content'];
    $new_link = $_POST['link'];
    $author_id = $_SESSION['user_id']; 
    $tag = $_POST['tags'];

    $stmt = $mysqli->prepare("INSERT INTO stories (title, author_ID, summary, story_contents,story_link,date_posted,story_tag) values (?,?,?,?,?,CURRENT_TIMESTAMP,?)");

    if($stmt){
        $stmt->bind_param('sissss', $new_title,$author_id,$new_summary,$new_content,$new_link,$tag);
        $stmt->execute();
        $stmt->close();
        header('Location : logged_in_landingpage.php');

    }
    else{
        printf("Query Prep Failed: %s\n", $mysqli->error);
    }

}



?>
</body>