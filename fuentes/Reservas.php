<?php
class Reservas implements Fuente
{
	public static function generarCanal($url, $canal, $imagenDefecto, $limite=10)
	{
		ob_start(); // Guardar en un buffer toda la salida
		$limite=6;
		$muestra=0;
		//$url = 'http://bib2.us.es/estado_salas/BDCT';
		$url = 'http://bib2.us.es/estado_salas/CRAIU';
		//url = 'http://bibing.us.es/estado_salas/BIA';
		//$url = 'http://bib2.us.es/estado_salas/BII';
		//$url = 'http://bib2.us.es/estado_salas/BCE';
		//$url = 'http://bib2.us.es/estado_salas/BDCT2';
		$html=file_get_contents($url);
		
		if($html ===  FALSE)
		{
			logError("No se pudo abrir la fuente para Estado de Salas desde '$url'");
		}
		
		$flag= strpos($html,'***CUERPO***');
		$tabla= substr($html,$flag);
		$secciones=explode("<tr>", $tabla);
		$salas=count($secciones);

		for ($i=2;$i<$salas;$i=$i+$limite){
			echo '<div class=item id= "'.$canal.$i.'"><br><table id="table1" width="780px">';
			echo $secciones[1];
			$muestra=0;
			
				for($a=$i;$salas>=$a && $muestra<$limite;$a++){
					echo $secciones[$a];
					$muestra++;
				}
				
			echo '</table></br> </div>';
		
		}
		
		return(ob_get_clean()); // Devolver el resultado del buffer
	}
}
?>