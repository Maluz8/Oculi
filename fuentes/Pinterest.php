<?php
class Pinterest implements Fuente
{
	public static function generarCanal($url, $canal, $imagenDefecto, $limite=10)
	{
		ob_start(); // Guardar en un buffer toda la salida
		$xml = simpleXML_load_file($url, NULL, LIBXML_NOCDATA);

		if($xml ===  FALSE) {
			logError("No se pudo cargar el rss para Pinterest '$url'");
		}
 
		
		$resultado = count($xml->channel->item); /*Contamos el número de noticias*/
		$resultado = ($resultado>$limite)?$limite:$resultado;
		
		/*Lectura del rss*/
		for ($i=0; $i < $resultado;$i++)
		{
			$item= html_entity_decode($xml->channel->item[$i]->description[0]);			
			$noticia = substr($item, strpos($item, 'src="')+5);
			$img = substr($noticia, 0, strpos($noticia, '"'));
			if(empty($img))
				$img = $imagenDefecto;
			
			$noticia = substr($noticia, strpos($noticia, '<p>')+3);
			$noticia = substr($noticia, 0, strlen($noticia)-4);

			$autor=explode("/",$noticia);
			
			echo '<div class="item" id="'.$canal.$i.'" style="background-image:' . "url('$img');" . '">';	
			echo '<div class="adq"><div class="titulo"><p>';
			echo $autor[0];
			echo '</p></div><div class="texto"><p>';
			echo $autor[1];
			echo '</p></div></div></div>';
		}


		return(ob_get_clean()); // Devolver el resultado del buffer
	}
}
?>
