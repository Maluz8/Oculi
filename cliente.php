<?php
require_once __DIR__.'/core.php';

// Recuperar configuración
$config = recuperarConfiguracion();

// Identificar a la pantalla cliente
$pantalla = identificarPantalla($config);

$tema = 'default';

if($pantalla!==null)
{
	$grupo = $config['opciones']['grupos'][$pantalla['grupo']];
	if($grupo!==null)
	{
		// Recuperar tema que esa pantalla utiliza
		$tema = $grupo['tema'];
		$titulo = $grupo['titulo'];
		if($grupo['tActualizar']==null)
			$tActualizar = 15;
		else
			$tActualizar = $grupo['tActualizar'];
		if($grupo['tRotacion']==null)
			$tRotacion = 5;
		else
			$tRotacion = $grupo['tRotacion'];
	}
}
// Devolver el cliente de ese tema
if((include(__DIR__."/temas/$tema/cliente.php"))==FALSE)
{
	require(__DIR__."/temas/default/cliente.php");
}
?>