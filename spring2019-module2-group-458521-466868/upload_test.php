<!DOCTYPE html>
<html lang ="en">
<head>
	<title>Upload</title>
</head>
<body>

    <form enctype="multipart/form-data" action="upload.php" method="POST">
		<p>
			<input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
			<label for="uploadfile_input">Choose a file to upload:</label> <input name="uploadedfile" type="file" id="uploadfile_input" />
		</p>
		<p>
			<input type="submit" value="Upload File" />
		</p>
	</form>

<?php
	session_start();
?>
</body>

</html>
