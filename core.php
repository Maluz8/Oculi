<?php
function logError($error)
{
	global $DEBUG;
	if($DEBUG==TRUE)
	{
		echo("<h3>Error en la aplicación:</h3><p>$error</p><h3 style=\"color: red;\">Este mensaje no debería aparecer si el entorno está en producción. Si es así, establezca la variable \$DEBUG a FALSE en el archivo opciones.php.</h3>");
		debug_print_backtrace();
	}
		error_log("[OCULUS] $error");
}

function verCanal($fuente, $url, $canal, $imagenDefecto, $limite)
{
	if((include_once(__DIR__."/fuentes/$fuente.php"))==TRUE)
	{
		$oFuente = new $fuente();
		
		if($limite==null)
			return $oFuente::generarCanal($url, $canal, $imagenDefecto);
		else
			return $oFuente::generarCanal($url, $canal, $imagenDefecto, $limite);
	}
	else
	{
		logError("Fuente '$fuente' no disponible. ¿Existe el archivo ".__DIR__."/fuentes/$fuente.php?");
		return FALSE;
	}
}

// Identificar a la pantalla que se está conectando
function identificarPantalla($config)
{
	// Información del cliente y canal solicitado
	$ipCliente = $_SERVER['REMOTE_ADDR']; // IP del cliente
	$nombreCliente = gethostbyaddr($ipCliente); // IP del cliente

	// Encontrar pantalla en configuración. Primero por nombre, luego por IP
	$pantalla = $config['opciones']['pantallas'][$nombreCliente];
	if($pantalla==null)
	{
		$pantalla = $config['opciones']['pantallas'][$ipCliente];
		// Guardar estadísticas
		guardarEstadisticas($ipCliente);
	}
	else
	{
		// Guardar estadísticas
		guardarEstadisticas($nombreCliente);
	}
	
	return $pantalla;
}

function recuperarConfiguracion()
{
	$json = file_get_contents("config.json");
	return( json_decode($json, true));
}

function guardarEstadisticas($pantalla)
{
	$estadisticas = json_decode(file_get_contents("conexiones.json"), true);
	$estadisticas['conexiones'][$pantalla]['ultima'] = date('d/m/Y-H:i:s');
	$estadisticas['conexiones'][$pantalla]['total']++;

	file_put_contents(dirname(__FILE__).'/conexiones.json', json_encode($estadisticas));
}
?>