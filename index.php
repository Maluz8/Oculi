<?php
require_once __DIR__.'/modelos/Fuente.php';
require_once __DIR__.'/core.php';
require __DIR__.'/opciones.php';


// Recuperar configuración
$config = recuperarConfiguracion();

// Identificar a la pantalla cliente
$pantalla = identificarPantalla($config);

if($pantalla==null)
	logError("Error. Pantalla no identificada.");

// Identificar el 
$grupo = $config['opciones']['grupos'][$pantalla['grupo']];

// Recuperar tema que esa pantalla utiliza
$tema = $grupo['tema'];

foreach ($grupo['canales'] as $canalP)
{
	$canal = $config['opciones']['canales'][$canalP];
	
	$datos = verCanal($canal['fuente'], $canal['url'], $canalP, $canal['imagen'], $canal['limite']);
	
	if($datos==FALSE)
	{
		// Error en algún punto
		logError("Error al reproducir el canal de fuente {$canal['fuente']} con URL {$canal['url']}");
	}
	else
	{
		if((include(__DIR__."/temas/$tema/index.php"))==FALSE)
		{
			include(__DIR__."/temas/default/index.php");
		}
	}
}
?>