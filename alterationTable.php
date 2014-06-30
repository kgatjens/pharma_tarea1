
<div class="dataContainer">
  <h3>Hay alteraci&oacute;n</h3>
  <p>La cadena introducida ha presentado alteraci&oacute;n para los casos estudiados
   a continuaci&oacute;n</p>
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
              foreach ($sequenceDataAlter as $key => $value) {
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