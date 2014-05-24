
<a href="index.php" class="btn btn-info btn-lg">Ir al buscador</a>
<h3>Secuencia:</h3>
<div class="bs-docs-grid">
	<div class="row show-grid">
	  <div class="col-md-4"><h5>SpeciesNo</h5></div>
	  <div class="col-md-8"><?php echo $data['equence']['SpeciesNo']?></div>
	</div>
	<div class="row show-grid">
	  <div class="col-md-4"><h5>SequenceNo</h5></div>
	  <div class="col-md-8"><?php echo $data['equence']['SequenceNo']?></div>
	</div>
	<div class="row show-grid">
	  <div class="col-md-4"><h5>SequenceDesc/h5></div>
	  <div class="col-md-8"><?php echo $data['equence']['SequenceDesc']?></div>
	</div>
	<div class="row show-grid">
	  <div class="col-md-4"><h5>SequenceLength</h5></div>
	  <div class="col-md-8"><?php echo $data['equence']['SequenceLength']?></div>
	</div>	
</div>

<h3>Especie:</h3>
<div class="bs-docs-grid">
	<div class="row show-grid2">
	  <div class="col-md-4"><h5>SpeciesNo</h5></div>
	  <div class="col-md-8"><?php echo $data['species']['SpeciesNo']?></div>
	</div>
	<div class="row show-grid2">
	  <div class="col-md-4"><h5>SpeciesID</h5></div>
	  <div class="col-md-8"><?php echo $data['species']['SpeciesID']?></div>
	</div>
	<div class="row show-grid2">
	  <div class="col-md-4"><h5>SpeciesUid</h5></div>
	  <div class="col-md-8"><?php echo $data['species']['SpeciesUid']?></div>
	</div>
	<div class="row show-grid2">
	  <div class="col-md-4"><h5>Finished</h5></div>
	  <div class="col-md-8"><?php echo $data['species']['Finished']?></div>
	</div>	
	<div class="row show-grid2">
	  <div class="col-md-4"><h5>SequenceNo</h5></div>
	  <div class="col-md-8"><?php echo $data['species']['SequenceNo']?></div>
	</div>	
</div>

<h3>Genes:</h3>

<table class="table table-striped">
        <thead>
          <tr>
            <th>GeneProduct</th>
            <th>GeneCOG</th>
            <th>GeneCode</th>
            <th>GeneSynonym</th>
            <th>GeneName</th>
            <th>GeneLength</th>
            <th>GeneStart</th>
            <th>GeneEnd</th>
            <th>GeneStrand</th>
          </tr>
        </thead>
        <tbody>
          
          	<?php 
          	foreach ($data['genes'] as $key => $value) {
          		echo "<tr>";
          		echo "<td>".$value['GeneProduct']."</td>";
          		echo "<td>".$value['GeneCOG']."</td>";
          		echo "<td>".$value['GeneCode']."</td>";
          		echo "<td>".$value['GeneSynonym']."</td>";
          		echo "<td>".$value['GeneName']."</td>";
          		echo "<td>".$value['GeneLength']."</td>";
          		echo "<td>".$value['GeneStart']."</td>";
          		echo "<td>".$value['ssGeneEnds']."</td>";
          		echo "<td>".$value['GeneStrand']."</td>";
          		echo "</tr>";		
          	}
          	?>
          
          
        </tbody>
</table>







