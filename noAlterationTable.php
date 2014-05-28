
<div class="dataContainer">
  <h3>No hay alteraci&oacute;n</h3>
  <p>La cadena introducida tiene similitud con las siguientes cadenas pero no muestra 
  alteraci&oacute;n de tal forma que la droga no tiene ning&uacute;n tipo de efecto</p>
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
            	foreach ($sequenceData as $key => $value) {
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
