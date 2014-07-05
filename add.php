<?php
include('template/header.php');

echo @$message;

?>
<form class="" style="width:640px" role="form"  action="main.php" method="post">
  <div class="form-group">
    <label for="pharma">F&aacute;rmaco</label>
    <input name="pharma" type="text" class=" form-control input-small" id="pharma" placeholder="...">
    <p class="help-block">Ingrese el nombre del medicamento</p>

    <label for="gene">Gen</label>
    <input name="gene" type="text" class="form-control" id="gene" placeholder="...">
    <p class="help-block">Ingrese el Gen</p>

    <label for="snp">SNP</label>
    <input name="snp" type="text" class="form-control" id="snp" placeholder="...">
    <p class="help-block">Ingrese el Polimorfismo de Nucle&oacute;tido Simple</p>

    <label for="sequense">Secuencia</label>
    <input name="sequense" type="text" class="form-control" id="sequense" placeholder="...">
    <p class="help-block">Ingrese la secuencia </p>

    <label for="metabolizer">Info / Metabolizador</label>
    <input name="metabolizer" type="text" class="form-control" id="metabolizer" placeholder="...">
    <p class="help-block">Ingrese informaci&oacute;n sobre el f&aacute;rmaco o el caso en particular</p>
  </div>

  <button type="submit" class="btn btn-default">Agregar Secuencia</button>
</form>

<?php
include('template/footer2.php'); 
?>