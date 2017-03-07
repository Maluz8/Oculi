<?php
class Wordpress implements Fuente
{
	public static function generarCanal($url, $canal, $imagenDefecto, $limite=10)
	{
		ob_start(); // Guardar en un buffer toda la salida
		$xml0 = file_get_contents($url);
		$xml1 = str_replace('<media:', '<', $xml0);
		$xml1 = str_replace('media:', '', $xml1);
		$xml = simplexml_load_string($xml1);
		
		if($xml ===  FALSE) {
	  		logError("No se pudo abrir la fuente para Wordpress desde '$url'");
		}
		
		$resultado = count($xml->channel->item); /*Contamos el número de noticias*/

		$resultado = ($resultado>$limite)?$limite:$resultado;
		
		/*Lectura del rss*/
		for ($i=0; $i < $resultado;$i++)
		{
			$imagen =$xml->channel->item[$i]->children("media", true);
			$src = $imagenDefecto;
			if ($xml->channel->item[$i]->content[1]['url'] != NULL)
			{
				$src = $xml->channel->item[$i]->content[1]['url'];
			}
			echo '<div class="item" id="'.$canal.$i.'" style="background-image:' . "url('$src');" . '">';
		
			
			echo '<div class="noticia"><div class="titulo"><p>';
			$titular= $xml->channel->item[$i]->title;
			echo $titular;
			echo '</p></div><div class="texto"><p>';
			$descripcion= $xml->channel->item[$i]->description;
			$subcadena = substr($descripcion, 0, 200);
			$fin = strrpos($subcadena, '.')+1;
			if((strlen($subcadena)-$fin)>=50)
				$fin = strrpos($subcadena, ' ');
			echo substr($subcadena, 0, $fin);
			echo ' [...]</p></div></div></div>';
		}
		return(ob_get_clean()); // Devolver el resultado del buffer
	}
}
?>