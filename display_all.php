

<div class="dataContainer">
  <h3>Los F&aacute;rmacos en el sistema son:</h3>
  <p></p>
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



