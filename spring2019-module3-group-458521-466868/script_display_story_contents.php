<!DOCTYPE html>
<html lang='en'>

<head>  
    <link rel="stylesheet" type = "text/css" href="main_stylesheet.css"/>
    <title>Edit Stories</title>
</head>

<?php

require 'database.php';
session_start();
//grab the requiste story contents from the database

$story_to_edit_ID = $_GET['story_ID'];
$_SESSION['cur_story'] = $story_to_edit_ID;
$stmt = $mysqli->prepare("SELECT title,summary,story_contents,story_link FROM `stories` WHERE story_ID=?");

if($stmt){
    $stmt->bind_param('i', $story_to_edit_ID);
    $stmt->execute();
    $stmt->bind_result($title,$summary,$content,$story_link);
}
else{
	printf("Query Prep Failed: %s\n", $mysqli->error);
}


//display story title, summary, contents in appropriate input fields for editing

while($stmt->fetch()){
echo('<form action="script_edit_story.php" method = "POST">');

echo( sprintf(
'<label for = "title">Title: </label> <br>
<textarea name = "new_title" class = "edit" id = "title">%s</textarea><br>',$title));

echo(sprintf('<label for = "summary">Summary: </label><br> 
<textarea name = "new_summary" class = "edit" id = "summary">%s</textarea><br>',$summary));

echo(sprintf('<label for = "content">Content: </label> <br>
<textarea name = "new_content" class = "edit" id = "content">%s</textarea><br>', $content));

echo(sprintf('<label for = "link">Link (leave blank if you wish to link to internal site): </label> <br>
<textarea name = "new_link" class = "edit" id = "link" >%s</textarea>
<br>',$story_link));

echo('<label for="toggle-1">Change Story Tag</label>
<input type="checkbox" id="toggle-1">
<div class="link_change">

<label for = "tags">Tags: </label> <br>
<select name= "new_tag", id="select_tags" >
    <option value = "None" selected>--------------------------------------------------------------------------------------------------------</option>
    <option value = "NULL">Remove Tag</option>
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


</div><br>');

echo('<input type = "submit" value = "Save"/>
</form>');
}

$stmt->close();


?>