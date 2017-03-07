<?php
class Frame implements Fuente
{
	public static function generarCanal($url, $canal, $imagenDefecto, $limite=10)
	{
		ob_start(); // Guardar en un buffer toda la salida
		?>
		<div class="item" id ="frame<?php echo $canal;?>">
			<object type="text/html" width="100%" height="100%" class="frame" data="<?php echo($url);?>">
			</object>
		</div>
		<?php 
		return(ob_get_clean()); // Devolver el resultado del buffer
	}
}
?>