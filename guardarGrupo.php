<?php

function guardarGrupo(){
	
	$fichero = json_decode(file_get_contents("config.json"), true);
	$fichero['opciones']['grupos'][$_POST['grupo']]['tema'] = $_POST['tema'];
	$fichero['opciones']['grupos'][$_POST['grupo']]['titulo'] = $_POST['titulo'];
	$fichero['opciones']['grupos'][$_POST['grupo']]['tActualizar'] = $_POST['tActualizacion'];
	$fichero['opciones']['grupos'][$_POST['grupo']]['tRotacion'] = $_POST['tRotacion'];
	$fichero['opciones']['grupos'][$_POST['grupo']]['canales'] = $_POST['canales'];
	 file_put_contents(dirname(__FILE__).'/config.json', json_encode($fichero));	
	
}

guardarGrupo();
var_dump($_POST);

header('Location: /oculus/admin.php');

?>