<!DOCTYPE html>
<html>
  <head>
    <title>BioBusqueda / FARMACOGENOMICA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <link href="css/social.css" rel="stylesheet">

  
  </head>
  <body>
  	<div class="container">
    
      <div class="page-header">
    
        <img  src="img/master.png">
        <a href="index.php"><p class="lead text-primary">Sistema Farmacogen&oacute;mico </p></a>
    
      </div>

      <?php
      include('social.php');
      ?>


<nav class="navbar navbar-default" role="navigation">
   <div>
      <ul class="nav navbar-nav ">
        <li><a class="btn btn-info" href="index.php">B&uacute;squeda</a></li>
        <li><a class="btn btn-success" href="display_all.php">Desplegar secuencias</a></li>
        <li><a class="btn btn-warning" href="add.php">Agregar una secuencia</a></li>
        <li><a class="btn btn-danger" href="upload_file.php">Agregar un Archivo CSV</a></li>
      </ul>
   </div>
</nav>

