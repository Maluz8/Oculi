<?php
function guardarCanal(){

	$fichero = json_decode(file_get_contents("config.json"), true);
	$fichero['opciones']['canales'][$_GET['canal']]['fuente'] = $_GET['fuente'];
	$fichero['opciones']['canales'][$_GET['canal']]['url'] = $_GET['url'];
	$fichero['opciones']['canales'][$_GET['canal']]['descripcion'] = $_GET['descripcion'];

	file_put_contents(dirname(__FILE__).'/config.json', json_encode($fichero));
}

guardarCanal();
header('Location: /oculus/admin.php');


?>