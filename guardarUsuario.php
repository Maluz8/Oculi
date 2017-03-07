<?php

function guardarUsuario(){
	
	$fichero = json_decode(file_get_contents("usuarios.json"), true);

	$fichero['usuarios'][$_GET['usuario']]['password'] = $_GET['pass'];
	$fichero['usuarios'][$_GET['usuario']]['grupos'] = $_GET['grupos'];
	echo file_put_contents(dirname(__FILE__).'/usuarios.json', json_encode($fichero));	
}

guardarUsuario();
header('Location: /oculus/admin.php');

?>