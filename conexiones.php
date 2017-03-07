<?php
function mostrarConexiones()
{
	$json = file_get_contents("conexiones.json");
	$conexiones = json_decode($json, true);
	$pantallas=$conexiones['conexiones'];
	$key= array_keys($pantallas); ?>

	<div class="col-md-8">
		<table class="table table-bordered">
	    <thead>
	      <tr>
	        <th>IP Pantalla</th>
	        <th>Última conexión</th>
	        <th>Total conexiones</th>
	      </tr>
	    </thead>
	    <tbody>
    	
			<?php 
				$i=0;
				foreach($pantallas as $obj){
					
					echo '<tr><td>'.$key[$i].'</td>';
					echo '<td>'.$obj['ultima'].'</td>';
					echo '<td>' .$obj['total'].'</td></tr>';
					$i++;
					
				}
}

	require(__DIR__."/temas/default/conexiones.php");
?>
	</tbody>
</table>
</div>