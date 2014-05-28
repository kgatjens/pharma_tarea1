
<div class="dataContainer">
  <h3>Hay alteraci&oacute;n</h3>
  <p>La cadena introducida ha presentado alteraci&oacute;n para los casos estudiados
   a continuaci&oacute;n</p>
   <p>*Pendiente definir las cantidades</p>
  <table class="table table-striped">
          <thead>
            <tr>
              <th>Drug</th>
              <th>Gene</th>
              <th>SNP</th>
              <th>Sequence</th>
       
            </tr>
          </thead>
          <tbody>
            
              <?php 
              foreach ($sequenceDataAlter as $key => $value) {
                echo "<tr>";
                echo "<td>".$value['pharma']."</td>";
                echo "<td>".$value['gene']."</td>";
                echo "<td>".$value['snp']."</td>";
                echo "<td>".$value['sequence']."</td>";
                echo "</tr>";   
              }
              ?>
            
            
          </tbody>
  </table>
</div>