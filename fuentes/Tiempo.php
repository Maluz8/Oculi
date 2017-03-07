<?php
class Tiempo implements Fuente
{
	public static function generarCanal($url, $canal, $imagenDefecto, $limite=10)
	{
		ob_start(); // Guardar en un buffer toda la salida
		
		?>
		<div class="item" id="tiempo">
			<div id="TT_<?php echo($url);?>">Pronóstico de Tutiempo.net</div>
			<script type="text/javascript" src="http://www.tutiempo.net/widget/eltiempo_<?php echo($url);?>"></script>
		</div>
		<?php 
		
		return(ob_get_clean()); // Devolver el resultado del buffer
	}
}
?>