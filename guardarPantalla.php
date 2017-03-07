<?php

function guardarPantalla(){
	$fichero = json_decode(file_get_contents("config.json"), true);
	
	if ($_POST['borrar']===1){
		unset($fichero['opciones'][$_POST['ip']]);
		header("Location: /oculus/admin.php?posicion=4");
	}
	else{


	$fichero['opciones']['pantallas'][$_POST['ip']]['nombre'] = $_POST['nombre'];
	
	$fichero['opciones']['pantallas'][$_POST['ip']]['grupo'] = $_POST['grupo'];

	}
	file_put_contents(dirname(__FILE__).'/config.json', json_encode($fichero));
	header("Location: /oculus/admin.php?posicion=4");
}

guardarPantalla();


?>