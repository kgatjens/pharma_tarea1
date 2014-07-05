<?php
include('template/header.php');

//$action="upload";// action to display all the drugs in a list.

?>
<form action="results.php" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file"><br>
<input type="submit" name="submit" value="Submit">
</form>




