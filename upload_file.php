<?php
include('template/header.php');

//$action="upload";// action to display all the drugs in a list.

?>
<form action="results.php" method="post" enctype="multipart/form-data">

	<fieldset >
		Seleccione un archivo por subir: <br />
		<input type="file" name="file"  />
		<br />
		<input type="submit" value="Subir Archivo CSV" />

	</fieldset>
</form>




