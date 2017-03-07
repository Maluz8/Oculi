<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Gestión de Oculus++ - Estadísticas </title>
<style><?php require __DIR__ . '/css/estilo.css';?></style>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css"></link>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="cabecera">
		<div id="titulo"><div class="loggedin"><h3></h3></div><h2>Oculus++</h2></div><img src="temas/BUS/bus.png">
	</div>
	<div class="cuerpo">
		<?php mostrarConexiones();?>
	</div>
	<div id="pie">
		<div>Biblioteca Universidad de Sevilla</div><div id="web">http://bib.us.es</div>
	</div>
</body>
</html>