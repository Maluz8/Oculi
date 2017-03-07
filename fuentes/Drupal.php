<?php
class Drupal implements Fuente
{
	public static function generarCanal($url, $canal, $imagenDefecto, $limite=10)
	{
		ob_start(); // Guardar en un buffer toda la salida
		$url = 'http://150.214.182.236/noticias-oculus.xml/';
		$xml = simpleXML_load_file($url);
		
		if($xml ===  FALSE)
		{
			logError("No se pudo abrir la fuente para Drupal desde '$url'");
		}
		
		$resultado = count($xml->channel->item); /*Contamos el número de noticias*/
		$resultado = ($resultado>$limite)?$limite:$resultado;

		/*Lectura del rss*/
		for ($i=0; $i < $resultado;$i++)
		{
		
			$imagen =$xml->channel->item[$i]->enclosure;
			$im=explode('"', $imagen);
			$img = $im[1];
			if(empty($img))
				$img = $imagenDefecto;
			echo '<div class="item" id="'.$canal.$i.'" style="background-image:' . "url('$img');" . '">';
			echo '<div class="noticia"> <div class="titulo"> <p>';
			echo $xml->channel->item[$i]->title;
			echo '</p></div><div class="texto"><p>';
			echo $xml->channel->item[$i]->link;
			echo '</p></div></div></div>';
		
		}
		
		return(ob_get_clean()); // Devolver el resultado del buffer
	}
}
?>