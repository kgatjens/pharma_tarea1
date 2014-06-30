
<div class="dataContainer">
  <h3>No hay alteraci&oacute;n</h3>
  <p>La cadena introducida tiene similitud con las siguientes cadenas pero no muestra 
  alteraci&oacute;n de tal forma que la droga no tiene ning&uacute;n tipo de efecto</p>
  <table class="table table-striped">
          <thead>
            <tr>
              <th>F&aacute;rmaco</th>
              <th>Gen</th>
              <th>SNP</th>
              <th>Letra Alteraci&oacute;n</th>
              <th>Secuencia</th>
       
            </tr>
          </thead>
          <tbody>
            
              <?php 
              foreach ($sequenceData as $key => $value) {
                echo "<tr>";
                echo "<td>".$value['pharma']."</td>";
                echo "<td>".$value['gene']."</td>";
                echo "<td>".$value['snp']."</td>";
                echo "<td>".$value['wrongChar']."</td>";
                echo "<td>".$value['sequense']."</td>";
                echo "</tr>";   
              }
              ?>
            
            
          </tbody>
  </table>
</div>
