<?php
	session_start();
	unset($_SESSION["usuario"]);
	unset($_SESSION["pass"]);
	unset($_SESSION["valida"]);
	
	require(__DIR__."/temas/default/logout.php");

	header('Refresh: 2; URL = login.php');
?>